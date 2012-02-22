<?php
namespace Controller;
use Helper\Form;

class Intervention extends Controller
{
	private $campus;
	private $speaker;
	private $interventions;
	private $session;
	
	public function __construct()
	{
		$this->campus = $this->loadModel('Campus');
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
	
	public function campus($campus)
	{
		$view = $this->loadView('interventions_campus');
		$this->campus->load($campus);
		$view->set('speaker', $this->speaker);
		$view->set('campus', $this->campus);
		$view->set('interventions', $this->interventions->listByCampus($this->campus));
		$view->set('logged', $this->session->logged);
		$view->render();
	}
	
	public function create()
	{
		$form = $this->loadHelper('Form');
		$form->addField('subject', 'Subject');
		$form->addField('campus', 'Campus', Form::ENUM_SELECT, $this->campus->getNames());
		$form->addField('begin', 'Begin');
		$form->addField('end', 'End');
		$form->addField('status', 'Status', Form::ENUM_SELECT, array('not started' => 'Not started', 'in progress' => 'In progress', 'done' => 'Done'));
		$form->addField('submit', 'Submit', Form::SUBMIT);
		
		$form->addAttribute('begin', 'id', 'begin');
		$form->addAttribute('end', 'id', 'end');
		
		$check = array('subject', 'campus', 'begin' => '#([0-9]{2}/){2}[0-9]{4}#', 'end' => '#([0-9]{2}/){2}[0-9]{4}#', 'status');
		
		if(isset($_POST['submit']) && $form->check($check, $_POST) === TRUE)
		{
			$data = $form->sanitize($_POST);
			$this->campus->load($data['campus']);
			$this->interventions->create($data['subject'], $this->speaker, $this->campus, $data['begin'], $data['end'], $data['status']);
			header('Location: mine');
			exit();
		}
		
		$view = $this->loadView('interventions_create');
		$view->set('logged', $this->session->logged);
		$view->set('form', $form);
		
		$view->render();
	}
}
