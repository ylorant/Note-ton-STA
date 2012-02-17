<?php
namespace Model;

class Campus extends Model
{
	private $id;
	private $name;
	
	public function __init($id = NULL, $name = NULL)
	{
		
		if($id !== NULL && $name === NULL)
			$this->load($id);
		
		if($id !== NULL && $name !== NULL)
		{
			$this->id = intval($id);
			$this->name = $name;
		}
	}
	
	public function __get($var)
	{
		return $this->$var;
	}
	
	public function __toString()
	{
		return $this->name;
	}
	
	public function load($id)
	{
		$this->prepare('SELECT id, name FROM campuses WHERE id = ?');
		$this->execute($id);
		$data = $this->fetch();
		
		if(!$data)
			return FALSE;
		
		$this->id = $data['id'];
		$this->name = $data['name'];
	}
	
	public function getList()
	{
		$this->prepare('SELECT id, name FROM campuses');
		$this->execute();
		
		$list = array();
		while($data = $this->fetch())
			$list[] = new Campus($data['id'], $data['name']);
		
		return $list;
	}
	
	public function getNames()
	{
		$list = $this->getList();
		$names = array();
		foreach($list as $campus)
			$names[$campus->id] = $campus->name;
		
		return $names;
	}
}
