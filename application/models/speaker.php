<?php
namespace Model;

class Speaker extends Model
{
	private $id;
	private $first_name;
	private $last_name;
	private $email;
	private $password;
	
	
	public function __init($data = NULL)
	{
		if($data !== NULL)
			$this->load($data);
	}
	
	public function __get($var)
	{
		return $this->$var;
	}
	
	public function save()
	{
		return array('id' => $this->id,
					 'first_name' => $this->first_name,
					 'last_name' => $this->last_name,
					 'email' => $this->email,
					 'password' => $this->password);
	}
	
	public function restore($data)
	{
		foreach($data as $key => $value)
			$this->$key = $value;
	}
	
	public function create($first_name, $last_name, $email, $password)
	{
		if(!$this->exists($email))
		{
			$this->prepare("INSERT INTO speakers (first_name, last_name, email, password) VALUES(?, ?, ?, ?)");
			$this->execute($first_name, $last_name, $email, sha1(crc32($email).$password));
			
			$this->load($this->lastInsertID());
			
			return TRUE;
		}
		else
			return FALSE;
	}
	
	public function exists($email)
	{
		$this->prepare("SELECT id FROM speakers WHERE email = ?");
		$this->execute($email);
		
		if($this->fetch())
			return TRUE;
		
		return FALSE;
	}
	
	public function authenticate($email, $password)
	{
		if(!$this->exists($email))
			return FALSE;
		
		$this->prepare('SELECT password FROM speakers WHERE email = ?');
		$this->execute($email);
		
		$data = $this->fetch();
		if(sha1(crc32($email).$password) == $data['password'])
			return TRUE;
		
		return FALSE;
	}
	
	public function load($data)
	{
		if(is_numeric($data))
			$this->loadFromID($data);
		elseif(filter_var($data, FILTER_VALIDATE_EMAIL))
			$this->loadFromEmail($data);
	}
	
	public function loadFromID($id)
	{
		$this->prepare('SELECT id, first_name, last_name, email, password FROM speakers WHERE id = ?');
		$this->execute($id);
		$data = $this->fetch();
		
		if($data)
			$this->_loadFromData($data);
		else
			return FALSE;
		
		return TRUE;
	}
	
	public function loadFromEmail($email)
	{
		$this->prepare('SELECT id, first_name, last_name, email, password FROM speakers WHERE email = ?');
		$this->execute($email);
		$data = $this->fetch();
		
		if($data)
			$this->_loadFromData($data);
		else
			return FALSE;
		
		return TRUE;
	}
	
	private function _loadFromData($data)
	{
		foreach($data as $key => $value)
			$this->$key = $value;
	}
}
