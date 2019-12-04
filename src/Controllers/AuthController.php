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
		
		// Verify the user
		if (empty($result->user))
		{
			log_message('error', 'Unable to decipher Firebase result: ' . $data);
			return;
		}

		// Verify required fields
		if (empty($result->user->uid) || empty($result->user->email))
		{
			log_message('error', 'Required fields missing from Firebase result: ' . $data);
			return;
		}

		// Try to match a user
		$row = [
			'email'       => $result->user->email,
			'username'    => $result->user->uid,
			'displayName' => $result->user->displayName ?? '',
		];

		$users = new UserModel();
		$user = $users
			->where('email', $row['email'])
			->orWhere('username', $row['username'])
			->first();
		
		// If no user was found then register
		if (empty($user))
		{
			$user = new User($row);
			$id = $users->insert($user);
			
			// Load the new record
			$user = $users->find($id);
		}

		// Log the user in
		$auth = service('authentication');
		$auth->login($user);
	}
}
