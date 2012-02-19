<?php
namespace Controller;
use Helper\Form;

class Speaker extends Controller
{
	//Login
	public function login()
	{
		if(!isset($_POST['login']))
		{
			$_SESSION['message'] = array('error', 'Unknown error.');
			header('Location:index');
			exit();
		}
		
		$model = $this->loadModel('Users_model');
		$check = $model->checkUser($_POST['login'], $_POST['password']);
		
		if($check === FALSE)
			$_SESSION['message'] = array('error', 'Invalid login.');
		else
			$_SESSION = array_merge($_SESSION, $check);
		
		header('Location:index');
	}
	
	//Logout
	public function logout()
	{
		session_destroy();
		header('Location:index');
	}
	
	//Registering
	public function register()
	{
		$form = $this->loadHelper('Form');
		$form->addField('first_name', 'First Name');
		$form->addField('last_name', 'Last Name');
		$form->addField('email', 'E-mail', Form::VARCHAR, NULL, Form::CHECK_EMAIL);
		$form->addField('password', 'Password', Form::PASSWORD, NULL, Form::CHECK_PASSWORD);
		$form->addField('password_confirmation', 'Password confirmation', Form::PASSWORD);
		$form->addField('submit', 'Submit', Form::SUBMIT);
		
		$check = array('first_name', 'last_name', 'password', 'password_confirmation' => 'password', 'email');
		
		if(isset($_POST['submit']) && $form->check($check, $_POST) === TRUE)
		{
			$model = $this->loadModel('Speaker');
		
			if(empty($_POST['login']) || empty($_POST['password']))
				$_SESSION['message'] = array('error', 'Fields are missing.');
			else if($model->userExists($_POST['login']))
				$_SESSION['message'] = array('error', 'Username already taken.');
			else if($_POST['password'] != $_POST['passwordcheck'])
				$_SESSION['message'] = array('error', 'Passwords are not the same.');
			else
			{
				$user = $model->createUser($_POST['login'],$_POST['password']);
				$_SESSION['message'] = array('confirm', 'Welcome, '.$user['login'].' !');
				$_SESSION['login'] = $user['login'];
				$_SESSION['password'] = $user['password'];
				$_SESSION['id'] = $user['id'];
			}
			header('Location:index');
		}
		
		$view = $this->loadView('register');
		$view->set('form', $form);
		$view->render();
		exit();
		
		
	}
}
