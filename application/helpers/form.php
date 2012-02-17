<?php
namespace Helper;
use \DOMDocument;

class Form
{
	private $fields;
	
	const VARCHAR = 1;
	const INTEGER = 2;
	const TEXT = 3;
	const ENUM_SELECT = 4;
	const ENUM_RADIO = 5;
	const PASSWORD = 6;
	const BUTTON = 7;
	const SUBMIT = 8;
	const BOOL = 9;
	
	const ALL_FIELDS = 100;
	
	const CHECK_EMAIL = 200;
	const CHECK_URL = 201;
	const CHECK_PASSWORDS = 202;
	
	public function __construct()
	{
		$this->fields = array();
	}
	
	public function generate($action, $method = 'POST', $files = FALSE)
	{
		$document = new DOMDocument();
		$form = $document->createElement('form');
		$form->setAttribute('method', $method);
		$form->setAttribute('action', $action);
		if($files == TRUE)
			$form->setAttribute('enctype', 'multipart/form-data');
		
		foreach($this->fields as $field)
		{
			$el = '';
			switch($field['type'])
			{
				case Form::TEXT:
					$el = $document->createElement('textarea');
					$el->nodeValue = $field['default'];
					break;
				case Form::ENUM_SELECT:
					$el = $document->createElement('select');
					foreach($field['values'] as $name => $value)
					{
						$option = $document->createElement('option');
						$option->setAttribute('value', $name);
						$option->nodeValue = $value;
						$el->appendChild($option);
					}
					break;
				case Form::ENUM_RADIO:
					if($field['display'])
					{
						$text = $document->createElement('label');
						$text->nodeValue = $field['display'].': ';
						$form->appendChild($text);
					}
					$form->appendChild($document->createElement('br'));
					foreach($field['values'] as $name => $value)
					{
						$label = $document->createElement('label');
						$label->nodeValue = $value;
						
						$radio = $document->createElement('input');
						$radio->setAttribute('type', 'radio');
						$radio->setAttribute('value', $name);
						$radio->setAttribute('name', $field['name']);
						
						if($field['default'] == $name)
							$radio->setAttribute('checked', 'checked');
						
						$radio->value = $value;
						$form->appendChild($radio);
						$form->appendChild($label);
						$form->appendChild($document->createElement('br'));
					}
					break;
				case Form::SUBMIT:
					$el = $document->createElement('input');
					$el->setAttribute('type', 'submit');
					$el->setAttribute('value', $field['display']);
					break;
				case Form::VARCHAR:
				case Form::INTEGER:
				case Form::PASSWORD:
				default:
					$el = $document->createElement('input');
					
					if($field['type'] != Form::PASSWORD)
						$el->setAttribute('type', 'text');
					else
						$el->setAttribute('type', 'password');
					
					if($field['default'] !== NULL)
						$el->setAttribute('value', $field['default']);
			}
			
			if($field['type'] != Form::ENUM_RADIO)
			{
				$el->setAttribute('name', $field['name']);
				
				if($field['type'] != Form::SUBMIT && $field['type'] != Form::BOOL)
				{
					if($field['display'])
					{
						$text = $document->createElement('label');
						$text->nodeValue = $field['display'].': ';
						$form->appendChild($text);
					}
				}
				
				$form->appendChild($el);
				$form->appendChild($document->createElement('br'));
			}
		}
		
		$document->appendChild($form);
		
		return $document->saveHTML();
	}
	
	public function addAttribute($name, $attributeName, $value)
	{
		if(!isset($this->fields[$name]))
			return FALSE;
		
		$this->fields[$name]['attributes'][$attributeName] = $value;
	}
	
	public function addField($name, $displayName, $type = Form::VARCHAR, $allowedValues = NULL, $regexMatch = NULL, $defaultValue = NULL)
	{
		if(!isset($this->fields[$name]))
			$this->fields[$name] = array('display' => $displayName, 'type' => $type, 'name' => $name, 'default' => $defaultValue, 'values' => $allowedValues, 'attributes' => array(), 'regex' => $regexMatch);
		else
			return FALSE;
		
		return TRUE;
	}
	
	public function deleteField($name)
	{
		if(!isset($this->fields[$name]))
			return FALSE;
		
		unset($this->fields[$name]);
		
		return TRUE;
	}
	
	/* Field check :
	 * 
	 * Check of $check with fields in $data. Here, $key represent the key of a $data element, $value its value :
	 * - field $key does not exists, field $value does not exists : the element is skipped.
	 * - field $key exists, field $value exists : Check similarity between the $key and $value fields
	 * - field $key exists, fields $value does not exists : checks the value of $key field, and its accordance with $value. Overrides $regexMatch
	 * 	 set at field declaration.
	 * - field $key does not exists, field $value exists : checks the value of $value field, in accordance with the $regexMatch parameter set at
	 * 	 the field's declaration.
	 */
	public function check($check, $data, $mandatory = Form::ALL_FIELDS)
	{
		
	}
}
