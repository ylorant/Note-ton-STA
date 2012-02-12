<?php
namespace Controller;

class Main extends Controller
{
	//Main page (search area mainly)
	public function index()
	{
		$campus = $this->loadModel('Campus');
		$list = $campus->getList();
		
		$template = $this->loadView('index');
		$template->set('campusList', $list);
		
		if(isset($_SESSION['login']))
		{
			$template->set('logged', TRUE);
			$template->set('userData', $_SESSION);
		}
		
		$template->render();
	}
	
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
		if(!isset($_POST['login']))
		{
			$_SESSION['message'] = array('error', 'Unknown error.');
			header('Location:index');
			exit();
		}
		
		$model = $this->loadModel('Users_model');
		
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
}

?>
