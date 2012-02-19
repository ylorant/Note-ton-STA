<?php
namespace Helper;
use \DOMDocument;

class Form
{
	private $fields;
	private $errorData;
	private $lastData;
	private $lastError;
	
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
	const CHECK_PASSWORD = 202;
	
	const ERR_EMPTY_FIELD = 300;
	const ERR_INVALID_FIELD = 301;
	
	public function __construct()
	{
		$this->fields = array();
		$this->errorData = array();
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
					if(in_array($field['name'], $this->errorData))
						$el->setAttribute('class', 'invalid');
					
					if(isset($this->lastData[$field['name']]))
						$el->setAttribute('value', $this->lastData[$field['name']]);
					
					foreach($field['attributes'] as $attr => $value)
						$el->setAttribute($attr, $value);
					
					if($field['display'])
					{
						$text = $document->createElement('label');
						$text->nodeValue = $field['display'].': ';
						$form->appendChild($text);
					}
					
					
				}
				
				$form->appendChild($el);
				
				if($field['note'])
				{
					$note = $document->createElement('span');
					$note->nodeValue = 'Note: '.$field['note'];
					$note->setAttribute('class', 'form-note');
					$form->appendChild($note);
				}
				
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
	
	public function addNote($field, $text)
	{
		$this->fields[$field]['note'] = $text;
	}
	
	public function addField($name, $displayName, $type = Form::VARCHAR, $allowedValues = NULL, $regexMatch = NULL, $defaultValue = NULL)
	{
		if(!isset($this->fields[$name]))
			$this->fields[$name] = array('display' => $displayName, 'type' => $type, 'name' => $name, 'default' => $defaultValue, 'values' => $allowedValues, 'attributes' => array(), 'regex' => $regexMatch, 'note' => NULL);
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
	
	public function getDisplayName($field)
	{
		return $this->fields[$field]['display'];
	}
	
	/* Field check :
	 * 
	 * Check of $check with fields in $data. Here, $key represent the key of a $data element, $value its value :
	 * - field $key does not exists, field $value does not exists : the element is skipped.
	 * - field $key exists, field $value exists : Check similarity between the $key and $value fields
	 * - field $key exists, field $value does not exists : checks the value of $key field, and its accordance with $value. Overrides $regexMatch
	 * 	 set at field declaration.
	 * - field $key does not exists, field $value exists : checks the value of $value field, in accordance with the $regexMatch parameter set at
	 * 	 the field's declaration.
	 */
	public function check($check, $data, $mandatory = Form::ALL_FIELDS)
	{
		$this->errorData = array();
		$this->lastData = $data;
		$return = TRUE;
		//Checking emptiness of the fields
		if($mandatory == Form::ALL_FIELDS)
			$mandatory = array_keys($this->fields);
		
		foreach($mandatory as $field)
		{
			if(empty($data[$field]))
			{
				$return = $this->lastError = Form::ERR_EMPTY_FIELD;
				$this->errorData[] = $field;
			}
		}
		
		if($return !== TRUE)
			return $return;
		
		//Checking validity of the fields, in accordance with $check array
		foreach($check as $field => $value)
		{
			if(isset($this->fields[$field]) && isset($data[$field]))
			{
				if(isset($this->fields[$value]) && isset($data[$value]) && $data[$field] != $data[$value])
				{
					$return = $this->lastError = Form::ERR_INVALID_FIELD;
					$this->errorData[] = $field;
				}
				elseif((!isset($this->fields[$value]) || !isset($data[$value])) && !$this->_checkValue($field, $data[$field], $value))
				{
					$return = $this->lastError = Form::ERR_INVALID_FIELD;
					$this->errorData[] = $value;
				}
			}
			elseif(isset($this->fields[$value]) && isset($data[$value]) && !$this->_checkValue($value, $data[$value]))
			{
				$return = $this->lastError = Form::ERR_INVALID_FIELD;
				$this->errorData[] = $value;
			}
		}
		
		if($return !== TRUE)
			return $return;
		
		return TRUE;
	}
	
	private function _checkValue($field, $data, $regex = NULL)
	{
		if($regex != NULL)
			$check = $regex;
		else
			$check = $this->fields[$field]['regex'];
			
		switch($check)
		{
			case Form::CHECK_EMAIL:
				return filter_var($data, FILTER_VALIDATE_EMAIL);
				break;
			case Form::CHECK_PASSWORD:
				return strlen($data) >= 5;
				break;
			case Form::CHECK_URL:
				return filter_var($data, FILTER_VALIDATE_URL);
				break;
			default:
				if(!empty($check))
					return preg_match($check, $data);
				else
					return TRUE;
		}
	}
}
