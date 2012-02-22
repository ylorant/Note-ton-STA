<?php
namespace Controller;
use Helper\Form;

class Main extends Controller
{
	//Main page (search area mainly)
	public function index()
	{
		$campus = $this->loadModel('Campus');
		$form = $this->loadHelper('Form');
		$form->addField('campus', NULL, Form::ENUM_SELECT, array_merge(array('-- Campus --'), $campus->getNames()));
		$form->addAttribute('campus', 'onchange', 'this.form.submit();');
		
		$template = $this->loadView('index');
		$template->set('form', $form);
		
		$template->render();
	}
	
	public function campus()
	{
		if(!isset($_POST['campus']))
		{
			header('Location: index');
			exit();
		}
		
		$campus = $this->loadModel('Campus');
		if($campus->load($_POST['campus']))
			header('Location: intervention/campus/'.$_POST['campus']);
		else
			header('Location: index');
	}
}

?>
