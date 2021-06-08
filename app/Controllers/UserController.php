<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
	public function __construct()
	{
		
	}

	public function index()
	{
		return view('login');
	}

	public  function Login()
	{
		$username =  $this->request->getVar("username");
		$password =  $this->request->getVar("password");

		$userModel = new UserModel();
		$userModel->select('*');
		$userModel->where('username', $username);
		$userModel->where('password', md5($password));
		$query = $userModel->get();
		if(!empty($query->getRow()))
		{
			$data = $query->getRow();
			$data->logged_in = true;
			session()->set('userData',$data);

			$response = [
				'success' => true,
				'msg' => "Login successfully!!!",
			];
		}
		else
		{
			$response = [
				'error' => false,
				'msg' => "Incorrect username and password",
			];
		}
		return $this->response->setJSON($response);
	}

	public function Signup()
	{
		return view('signup');
	}

	public function saveUser()
	{
		if(isset($_POST['btnSave']))
		{
			$userModel = new UserModel();
			$data = [
				"full_name" => $this->request->getVar("fullname"),
				"username" => $this->request->getVar("username"),
				"email" => $this->request->getVar("email"),
				"mobile_no" => $this->request->getVar("mobile_no"),
				"password" => md5($this->request->getVar("password")),
			];
			if ($userModel->insert($data))
			{
				$response = [
					'success' => true,
					'msg' => "User added successfully",
				];
			}
			else
			{
				$response = [
					'error' => false,
					'msg' => "Failed to create user",
				];
			}
			return $this->response->setJSON($response);
		}
	}

	public function forgotPassword()
	{
		return view('forgot_password');
	}

	public function Logout()
	{
		session()->destroy();
		//return redirect()->to('/');
		//return redirect()->route('/'); 
		return redirect('/');
	}
}
