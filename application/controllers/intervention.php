<?php
namespace Controller;
use Helper\Form;

class Intervention extends Controller
{
	public function __construct()
	{
		$this->loadModel('Campus');
		$this->speaker = $this->loadModel('Speaker');
		$this->interventions = $this->loadModel('Intervention');
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
			header('Location:../speaker/login');
			exit();
		}
	}
	
	public function mine()
	{
		$this->checkLogin();
		
		$view = $this->loadView('interventions_mine');
		$view->set('speaker', $this->speaker);
		$view->set('interventions', $this->interventions->listBySpeaker($this->speaker));
		$view->set('logged', $this->session->logged);
		$view->render();
	}
	
	
}
