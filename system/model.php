<?php
namespace Model;
use \PDO;

class Model {

	protected $_PDO;
	protected $_query;
	protected $_curParamID = 1;
	
	public function __construct()
	{
		$this->_PDO = new PDO(DB_ENGINE.':host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_DBNAME, DB_USER, DB_PW);
		$this->_PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$this->_PDO->exec('SET NAMES utf8');
		call_user_func_array(array($this, '__init'), func_get_args());
	}
	
	public function __init()
	{
		
	}
	
	public function to_bool($val)
	{
	    return !!$val;
	}
	
	public function to_date($val)
	{
	    return date('Y-m-d', $val);
	}
	
	public function to_time($val)
	{
	    return date('H:i:s', $val);
	}
	
	public function to_datetime($val)
	{
	    return date('Y-m-d H:i:s', $val);
	}
	
	public function prepare($query)
	{
		$this->_query = $this->_PDO->prepare($query);
	}
	
	public function bind($name, $value = NULL)
	{
		if($value === NULL)
			list($value, $name) = array($name, ++$this->_curParamID);
		
		$type = PDO::PARAM_STR;
		if(is_int($value))
			$type = PDO::PARAM_INT;
		
		$this->_query->bindValue($name, $value, $type);
	}
	
	public function execute()
	{
		$values = array();
		foreach(func_get_args() as $arg)
			$values[] = $arg;
		
		return $this->_query->execute($values);
	}
	
	public function fetch()
	{
		return $this->_query->fetch(PDO::FETCH_ASSOC);
	}
	
	public function fetchAll()
	{
		return $this->_query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function reset()
	{
		$this->_query->resetCursor();
	}
	
	public function drop()
	{
		unset($this->_query);
	}
	
	public function lastInsertID()
	{
		return $this->_PDO->lastInsertId();
	}
    
}
?>
