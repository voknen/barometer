<?php

class Expenses
{

	private $id;
	private $user_id;
	private $date_of_expense;
	private $type;
	private $value;

	
	public function __destruct() 
	{  
              
    }

    public function exchangeArray($data)
    {
		$this->user_id = (isset($data['user_id'])) ? $data['user_id'] : '';
		$this->date_of_expense = (isset($data['date_of_expense'])) ? $data['date_of_expense'] : '';
		$this->type = (isset($data['type_expense'])) ? $data['type_expense'] : '';
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

	public function setDate_of_expense($date_of_expense)
	{
		$this->date_of_expense = $date_of_expense;
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

	public function getDate_of_expense()
	{
		return $this->date_of_expense;
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
