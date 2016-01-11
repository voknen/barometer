<?php

class Users
{

	private $id;
	private $first_name;
	private $last_name;
	private $age;
	private $username;
	private $password;
	/**
	* Destruct the created object
	*/
	public function __destruct() 
	{  
              
    }

    /**
	*  Assign the data which is sent from the $_POST method to the properties of the class
	*
	* @param array $data
	*/
    public function exchangeArray($data)
    {
		$this->first_name = (isset($data['first_name'])) ? $data['first_name'] : '';
		$this->last_name = (isset($data['last_name'])) ? $data['last_name'] : '';
		$this->age = (isset($data['age'])) ? $data['age'] : '';
		$this->username = (isset($data['username'])) ? $data['username'] : '';
		$this->password = (isset($data['password'])) ? $data['password'] : '';
    }

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setFirst_name($first_name)
	{
		$this->first_name = $first_name;
	}

	public function setLast_name($last_name)
	{
		$this->last_name = $last_name;
	}

	public function setAge($age)
	{
		$this->age = $age;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getFirst_name()
	{
		return $this->first_name;
	}

	public function getLast_name()
	{
		return $this->last_name;
	}

	public function getAge()
	{
		return $this->age;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}
		
}
