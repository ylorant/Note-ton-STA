<?php
namespace Model;

class Intervention extends Model
{
	private $id;
	private $subject;
	private $speaker;
	private $start;
	private $end;
	private $campus;
	private $status;
	private $avg_mark;
	private $evaluations;
	
	public function __init($id = NULL)
	{
		if($id != NULL)
			$this->load($id);
	}
	
	public function __get($var)
	{
		return $this->$var;
	}
	
	public function load($id)
	{
		$this->prepare('SELECT i.id, i.subject, i.speaker, i.start, i.end, i.campus, i.status, AVG(m.value) AS avg_mark FROM interventions i JOIN evaluations e ON e.intervention = i.id JOIN marks m ON m.evaluation = e.id WHERE i.id = ?');
		$this->execute($id);
		
		$data = $this->fetch();
		if(!$data)
			return FALSE;
		
		foreach($data as $key => $value)
			$this->$key = $value;
		
		$this->speaker = new Speaker($this->speaker);
		$this->campus = new Campus($this->campus);
		
		$this->prepare('SELECT COUNT(id) AS evaluations FROM evaluations WHERE intervention = ?');
		$this->execute($id);
		
		$data = $this->fetch();
		$this->evaluations = $data['evaluations'];
		
		return TRUE;
	}
	
	public function listBySpeaker($speaker)
	{
		$this->prepare('SELECT id FROM interventions WHERE speaker = ?');
		$this->execute($speaker->id);
		
		$return = array();
		while($data = $this->fetch())
			$return[$data['id']] = new Intervention($data['id']);
		
		return $return; 
	}
	
	public function listByCampus($campus)
	{
		$this->prepare('SELECT id FROM interventions WHERE campus = ?');
		$this->execute($campus->id);
		
		$return = array();
		while($data = $this->fetch())
			$return[$data['id']] = new Intervention($data['id']);
		
		return $return; 
	}
	
	public function getList()
	{
		$this->prepare('SELECT id FROM interventions');
		$this->execute();
		
		$return = array();
		while($data = $this->fetch())
			$return[$data['id']] = new Invervention($data['id']);
		
		return $return;
	}
	
	public function create($subject, $speaker, $campus, $begin, $end, $status)
	{
		$begin = date('Y-m-d', strtotime($begin));
		$end = date('Y-m-d', strtotime($end));
		
		trigger_error($begin.' '.$end);
		$this->prepare('INSERT INTO interventions (subject, speaker, campus, start, end, status) VALUES(?, ?, ?, ?, ?, ?)');
		$this->execute($subject, $speaker->id, $campus->id, $begin, $end, $status);
		
	}
}
