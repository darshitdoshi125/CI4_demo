<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
	public function __construct()
	{
		$is_logged_in = session()->get('userData')->logged_in;
		if(!isset($is_logged_in) || $is_logged_in!==TRUE) {
			redirect('/');
			exit;
		}
	}

	public function index()
	{
		return view('welcome_message');
	}

	public function accountSetting()
	{
		$data['title'] = 'Account Setting';
		$data['menu'] = "accountSetting";
		$data['main_content'] = 'account_setting';
		return view('partials/template',$data);
	}

	public function updateProfile() 
	{
		$userModel = new UserModel();
		$id = session()->get('userData')->id;
		if($file = $this->request->getFile('profilepic')) 
		{
			if ($file->isValid() && !$file->hasMoved()) 
			{
				if(!file_exists('uploads/profile'))
				{
					mkdir('uploads/profile', 0777, true);
				}
				$userModel->select('profile_image');
				$userModel->where('id', $id);		
				$userModel->where('status', 'active');			
				$query = $userModel->get();
				$profile_image = $query->getRow()->profile_image;
				if(file_exists('../public/uploads/profile/'.$profile_image) && $profile_image != '') 
				{
					unlink('../public/uploads/profile/'.$profile_image);
				}
               	$name = $file->getName();
               	$ext = $file->getClientExtension();
               	$newName = $file->getRandomName(); 
               	$file->move('../public/uploads/profile', $newName);

               	$data['profile_image'] = $newName;
			}
			else 
			{
				$response = [
					'error' => false,
					'msg' => "File not uploaded",
				];
			}
		}
		$data['full_name'] = $this->request->getVar("fullname");
		$data['username'] = $this->request->getVar("username");
		$data['email'] = $this->request->getVar("email");
		$data['mobile_no'] = $this->request->getVar("mobile_no");
		if ($userModel->update($id,$data))
		{
			$userModel->select('*');
			$userModel->where('id', $id);
			$query = $userModel->get();
			$data = $query->getRow();
			$data->logged_in = true;
			session()->set('userData',$data);

			$response = [
				'success' => true,
				'msg' => "Account details saved.",
			];
		}
		else
		{
			$response = [
				'error' => false,
				'msg' => "something went wrong please try again",
			];
		}
		return $this->response->setJSON($response);
	}

	public function changePassword()
	{
		$userModel = new UserModel();
		$id = session()->get('userData')->id;
		$password = session()->get('userData')->password;

		$current_pwd = $this->request->getVar('current_password');
		$new_pwd = $this->request->getVar('new_password');
		$confirm_pwd = $this->request->getVar('confirm_password');

		if(md5($current_pwd) == $password) {
			if($new_pwd == $confirm_pwd)
			{
                $edit_data['password'] = md5($new_pwd);
				$userModel->update($id, $edit_data);
				$response = [
					'success' => true,
					'msg' => "Password changed successfully.",
				];
            }
			else
			{
				$response = [
					'error' => false,
					'msg' => "New password and confirm password does not match.",
				];
            }
		}
		else
		{
			$response = [
				'error' => false,
				'msg' => "Please enter correct current password.",
			];
		}
		return $this->response->setJSON($response);
	}
}
