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
		$form->addField('campus', NULL, Form::ENUM_SELECT, $campus->getNames());
		$form->addAttribute('campus', 'onchange', 'this.form.submit();');
		$list = $campus->getList();
		
		
		$template = $this->loadView('index');
		//~ $template->set('campusList', $);
		$template->set('form', $form);
		
		if(isset($_SESSION['login']))
		{
			
		}
		
		$template->render();
	}
}

?>
