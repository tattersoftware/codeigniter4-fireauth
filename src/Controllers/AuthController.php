<?php namespace Tatter\MythAuthFirebase\Controllers;

use CodeIgniter\Controller;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class AuthController extends Controller
{
	/**
	 * Return point for successful Firebase login.
	 * Handles registration (if necessary) and logging in.
	 */
	public function callback()
	{
		// Parse the data
		$data = $this->request->getBody();
		if (! $result = json_decode($data))
		{
			log_message('error', 'Invalid JSON data in Firebase request: ' . $data);
			return;
		}
		
		// Verify the user token
		if (empty($result->user->stsTokenManager->accessToken))
		{
			log_message('error', 'Unable to decipher Firebase result: ' . $data);
			return;
		}
		$token = $result->user->stsTokenManager->accessToken;
		unset($result);

		// Verify the token with Google
		$url      = 'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=' . env('firebase.apiKey');
		$client   = service('curlrequest');
		$response = $client->request('POST', $url, ['json' => ['idToken' => $token]]);
		if (! $identity = json_decode($response->getBody()))
		{
			log_message('error', 'Unable to verify IdentityToolkit response: ' . $response->getBody());
			return;
		}
		unset($response);

		// Check for errors
		if (! empty($identity->error))
		{
			log_message('error', 'User token failed to validate: ' . $identity->error->message);
			return;		
		}
		if (empty($identity->users))
		{
			log_message('error', 'Ambiguous response from IdentityToolkit: ' . $response->getBody());
			return;		
		}
		$entity = reset($identity->users);
		unset($identity);

		// Verify required fields
		// Myth:Auth currently requires all these - this may change in the future
		if (empty($entity->email) || empty($entity->localId) || empty($entity->passwordHash))
		{
			log_message('error', 'Required fields missing from result: ' . json_encode($entity));
			return;
		}
		
		// Convert it to Myth:Auth format
		$row = [
			'email'         => $entity->email,
			'username'      => $entity->localId,
			'password_hash' => $entity->passwordHash, // this will prevent local logins
			'displayName'   => $entity->displayName ?? '',
			'active'        => 1,
			'created_at'    => date('Y-m-d H:i:s', $entity->createdAt / 1000),			
		];
		unset($entity);

		// Try to match a user
		$users = new UserModel();
		$user = $users
			->where('email', $row['email'])
			->orWhere('username', $row['username'])
			->first();
		
		// If no user was found then register a new one
		if (empty($user))
		{
			$user = new User($row);
			if (! $id = $users->insert($user))
			{
				log_message('error', 'Unable to register user: ' . implode('. ', $users->errors()));
				return;
			}
			
			// Load the new record
			$user = $users->find($id);
		}
		// Otherwise update with the latest info from Firebase
		{
			$row['id'] = $user->id;
			if (! $users->update($user->id, $row))
			{
				log_message('error', 'Unable to update user: ' . implode(' ', $users->errors()));
			}
		}

		// Log the user in
		$auth = service('authentication');
		$auth->login($user, true);
	}
}
