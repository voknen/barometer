<?php

require 'users.php';
require 'DBconnect.php';

class UserDB extends Users 
{	

	public function connection()
	{
		$database_connect = new DBconnect();
		$connection = $database_connect->connect();
		return $connection;
	}

	public function register($post)
	{
		$errors = array();
		$user = new Users();
		$user->exchangeArray($post);

		$first_name=trim($user->getFirst_name());
		$user->setFirst_name($first_name);

		$last_name=trim($user->getLast_name());
		$user->setLast_name($last_name);

		$age=trim($user->getAge());
		$user->setAge($age);

		$username=trim($user->getUsername());
		$user->setUsername($username);
		
       $password=trim($user->getPassword());
	   $user->setPassword($password);

	   $_SESSION['first_name'] = $first_name;
	   $_SESSION['last_name'] = $last_name;
	   $_SESSION['age'] = $age;
	   $_SESSION['username'] = $username;
       $_SESSION['password'] = $password;

	    if (empty($first_name)) {
			$errors['first_name'] = "Моля въведете име!";
		}

		if (empty($last_name)) {
			$errors['last_name'] = "Моля въведете фамилия!";
		}

		if (empty($age)) {
			$errors['age'] = "Моля въведете възраст!";
		}

		if (!is_numeric($age)) {
			$errors['age'] = "Моля въведете число!";
		}

		if (empty($username)) {
			$errors['username'] = "Моля въведете потребителско име!";
		}

		if (empty($password)) {
			$errors['password'] = "Моля въведете парола!";
		}

		if ($this->exists($username)) {
			$errors['username'] = "Потребителското име е заето!";
		}
	
		if (count($errors) > 0) {
			return $errors;
		} else { 
		     $this->add($user);//create new user
		     return $errors = array();
		}	
	}

	public function login($post)
	{
		$errors = array();
		$user = new Users();
		$user->exchangeArray($post);

		$username = trim($user->getUsername());
        $user->setUsername($username);

		$password = trim($user->getPassword());
		$user->setPassword($password);

		$_SESSION['id'] = $this->getLogged_user_id($username);
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;

		if (empty($username)) {
			$errors['username'] = "Моля въведете потребителско име!";			
		}

		if (empty($password)) {
			$errors['password'] = "Моля въведете парола!";			
		}
		
  		if ($this->select($user) == false && !isset($errors['username'])) {
  			$errors['username'] = "Въведените потребителско име и/или парола са невалидни!";
  		} elseif ($this->select($user) == true) {
  			$_SESSION['isLogged'] = true;
  			
  		}

  		if (count($errors) > 0) {
			return $errors;
		} else {
			return $errors = array();
		}
	}

	public function exists($username)
	{
		$exists = false;

		$stmt = $this->connection()->prepare("SELECT username FROM users WHERE username = :username");
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->fetch()) {
			$exists=true;
		}
		return $exists;
	}

	public function add($object)
	{	
		$hashed_password = password_hash($object->getPassword(), PASSWORD_DEFAULT);
		$object->setPassword($hashed_password);
		
		$stmt = $this->connection()->prepare("INSERT INTO users(first_name, last_name, age, username, password) 
			VALUES(:first_name, :last_name, :age, :username, :hashed_password);");  
		$stmt->bindParam(':first_name', $object->getFirst_name(), PDO::PARAM_STR);
		$stmt->bindParam(':last_name', $object->getLast_name(), PDO::PARAM_STR);
		$stmt->bindParam(':age', $object->getAge(), PDO::PARAM_INT);
		$stmt->bindParam(':username', $object->getUsername(), PDO::PARAM_STR);
		$stmt->bindParam(':hashed_password', $object->getPassword(), PDO::PARAM_STR);
		
		$stmt->execute();
	}

	public function select($object)
	{	
		$loginPassword = false;

		$stmt = $this->connection()->prepare("SELECT password FROM users WHERE username = :username");
		$stmt->bindParam('username', $object->getUsername(), PDO::PARAM_STR);
		$stmt->execute();
		
		while ($row = $stmt->fetch()) {
			if (password_verify($object->getPassword(), $row['password']) == true) {
				$loginPassword = true;
			}
		}
		return $loginPassword;
	}

	public function getLogged_user_id($username)
	{	
		$stmt =$this->connection()->prepare("SELECT id FROM users WHERE username = :username");
		$stmt ->bindParam(':username', $username, PDO::PARAM_STR);
		$stmt->execute();

		while ($row = $stmt->fetch()) {
			return $row['id'];
		}
	}
}