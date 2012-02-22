<?php
namespace Controller;
use Helper\Form;

class Speaker extends Controller
{
	private $session;
	private $speaker;
	
	public function __construct()
	{
		$this->speaker = $this->loadModel('Speaker');
		$this->session = $this->loadHelper('Session');
		
		if($this->session->logged)
			$this->speaker->restore($this->session->speaker);
	}
	
	public function __destruct()
	{
		if($this->session->logged)
			$this->session->speaker = $this->speaker->save();
	}
	
	private function checkLogin()
	{
		if(!$this->session->logged)
		{
			header('Location:login');
			exit();
		}
	}
	
	//~ public function index()
	//~ {
		//~ $this->checkLogin();
		//~ 
		//~ $view = $this->loadView('speaker_index');
		//~ $view->set('speaker', $this->speaker);
		//~ $view->set('logged', $this->session->logged);
		//~ $view->render();
	//~ }
	
	//Login
	public function login()
	{
		$view = $this->loadView('login');
		$form = $this->loadHelper('Form');
		
		$form->addField('email', 'E-mail');
		$form->addField('password', 'Password', Form::PASSWORD);
		$form->addField('submit', 'Submit', Form::SUBMIT);
		
		$view->set('form', $form);
		
		if(isset($_POST['submit']))
		{
			if($form->check($check, $_POST))
			{
				$data = $form->sanitize($_POST);
				if($this->speaker->authenticate($data['email'], $data['password']))
				{
					$this->session->logged = TRUE;
					$this->speaker->load($_POST['email']);
					header('Location:../intervention/mine');
					return;
				}
				else
					$view->set('error', TRUE);
			}
		}
		
		$view->set('logged', FALSE);
		$view->render();
	}
	
	//Logout
	public function logout()
	{
		$this->session->logged = FALSE;
		header('Location:../index');
	}
	
	//Registering
	public function register()
	{
		$form = $this->loadHelper('Form');
		$form->addField('first_name', 'First Name');
		$form->addField('last_name', 'Last Name');
		$form->addField('email', 'E-mail', Form::EMAIL, NULL, Form::CHECK_EMAIL);
		$form->addField('password', 'Password', Form::PASSWORD, NULL, Form::CHECK_PASSWORD);
		$form->addField('password_confirmation', 'Password confirmation', Form::PASSWORD);
		$form->addField('submit', 'Submit', Form::SUBMIT);
		
		$check = array('first_name', 'last_name', 'password', 'password_confirmation' => 'password', 'email');
		
		if(isset($_POST['submit']) && $form->check($check, $_POST) === TRUE)
		{
			$data = $form->sanitize($_POST);
			
			$this->speaker->create($data['first_name'], $data['last_name'], $data['email'], $data['password']);
			$this->session->logged = TRUE;
			
			header('Location:../intervention/mine');
			return;
		}
		
		$view = $this->loadView('register');
		$view->set('logged', FALSE);
		$view->set('form', $form);
		$view->render();
	}
}
