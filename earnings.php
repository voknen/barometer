<?php

class Earnings
{

	private $id;
	private $user_id;
	private $date_of_earning;
	private $type;
	private $value;
	
	public function __destruct() 
	{  
              
    }

    public function exchangeArray($data)
    {
		$this->user_id = (isset($data['user_id'])) ? $data['user_id'] : '';
		$this->date_of_earning = (isset($data['date_of_earning'])) ? $data['date_of_earning'] : '';
		$this->type = (isset($data['type_earning'])) ? $data['type_earning'] : '';
		$this->value = (isset($data['value'])) ? $data['value'] : '';
    }
   
	public function setId($id)
	{
		$this->id = $id;
	}

	public function setUser_id($user_id)
	{
		$this->user_id = $user_id;
	}

	public function setDate_of_earning($date_of_earning)
	{
		$this->date_of_earning = $date_of_earning;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getUser_id()
	{
		return $this->user_id;
	}

	public function getDate_of_earning()
	{
		return $this->date_of_earning;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getValue()
	{
		return $this->value;
	}
		
}
