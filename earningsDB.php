<?php

require 'earnings.php';
require_once 'DBconnect.php';

class EarningsDB extends Earnings 
{	

	public function connection()
	{
		$database_connect = new DBconnect();
		$connection = $database_connect->connect();
		return $connection;
	}

	public function insert($post)
	{
		$errors = array();
		$earning = new Earnings();
		$earning->exchangeArray($post);

		$user_id = $_SESSION['id'];
		$earning->setUser_id($user_id);

		$date_of_earning = date("Y-m-d");
		$earning->setDate_of_earning($date_of_earning);

		$type = $earning->getType();
		$earning->setType($type);

		$value=trim($earning->getValue());
		$earning->setValue($value);
       

	   	$_SESSION['value'] = $value;

       //check if the field for the first name is empty
	    if (empty($value)) {
			$errors['value'] = "Моля въведете приход!";
		}

		if (!is_numeric($value)) {
			$errors['value'] = "Моля въведете число!";
		}

		if (count($errors) > 0) {
			return $errors;
		} else { 
		     $this->add($earning);
		     return $errors = array();
		}	
	}

	public function add($object)
	{	
		$stmt = $this->connection()->prepare("INSERT INTO earnings(user_id, date_of_earning, type, value)
			VALUES(:user_id, :date_of_earning, :type, :value);");  
		$stmt->bindParam(':user_id', $object->getUser_id(), PDO::PARAM_INT);
		$stmt->bindParam(':date_of_earning', $object->getDate_of_earning(), PDO::PARAM_STR);
		$stmt->bindParam(':type', $object->getType(), PDO::PARAM_STR);
		$stmt->bindParam(':value', $object->getValue(), PDO::PARAM_INT);
		
		$stmt->execute();
	}

	public function select($id, $limit = null)
	{	
		if ($limit != null) {
			$stmt = $this->connection()->prepare("SELECT id, date_of_earning, type, value 
			FROM earnings WHERE user_id = :id ORDER BY date_of_earning DESC LIMIT :limit_earnings;");
			$stmt->bindParam(':limit_earnings', $limit, PDO::PARAM_INT);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} else {
			$stmt = $this->connection()->prepare("SELECT id, date_of_earning, type, value 
			FROM earnings WHERE user_id = :id ORDER BY date_of_earning DESC;");
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
	}

	public function isEarningToUser($user_id, $earning_id)
	{
		$exists = false;
		$stmt = $this->connection()->prepare("SELECT id FROM earnings WHERE id = :earning_id 
											AND user_id = :user_id;");
		$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->bindParam(':earning_id', $earning_id, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetch(PDO::FETCH_OBJ)) {
			$exists = true;
		}

		return $exists;
	}
	public function getData($id)
	{
		$stmt = $this->connection()->prepare("SELECT type, value FROM earnings WHERE id = :id;");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	//checks the data before sending it to DB
	public function update($id, $post)
	{
		$errors = array();
		$earning= new Earnings();
		$earning->exchangeArray($post);

		$type = $earning->getType();
		$earning->setType($type);

		$value=trim($earning->getValue());
		$earning->setValue($value);

		$earning->setId($id);

	    if (empty($value)) {
			$errors['value'] = "Моля въведете приход!";
		}

		if (!is_numeric($value)) {
			$errors['value'] = "Моля въведете число!";
		}

		if (count($errors) > 0) {
			return $errors;
		} else { 
		     $this->edit($earning);
		     return $errors = array();
		}	
	}

	public function edit($object)
	{
		$stmt = $this->connection()->prepare("UPDATE earnings SET value = :value, type = :type WHERE id = :id ;");
		$stmt->bindParam(':value', $object->getValue(), PDO::PARAM_INT);
		$stmt->bindParam(':type', $object->getType(), PDO::PARAM_STR);
		$stmt->bindParam(':id', $object->getId(), PDO::PARAM_INT);
		$stmt->execute();
	}

	public function toBulgarian($type)
	{
    	$toBG = array(
    		'salary' 	  => 'Заплата',
    		'scholarship' => 'Стипендия',
    		'inheritance' => 'Наследство',
    		'other' 	  => 'Други'
    	);

        return $toBG[$type];
	}

	public function delete($id)
	{
      $stmt=$this->connection()->prepare("DELETE FROM earnings WHERE id = :id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
	}

	public function getAllEarnings($post)
	{
		$where = '';
		if ($post['type_balance'] == 'day') {
			$day = $post['year'] . "-" . $post['month'] . "-" . $post['day'];
			$where = 'date_of_earning="' . $day . '"';
		}
		if ($post['type_balance'] == 'week') {
			$from = $post['from_year'] . "-" . $post['from_month'] . "-" . $post['from_day'];
			$to = $post['to_year'] . "-" . $post['to_month'] . "-" . $post['to_day'];
			$where = 'date_of_earning BETWEEN "' . $from . '" AND "' . $to . '"';
		}
		if ($post['type_balance'] == 'month') {
			$from = $post['year'] . "-" . $post['month'] . "-1";
			$to =  $post['year'] . "-" . $post['month'] . "-31";
			$where = 'date_of_earning BETWEEN "' . $from . '" AND "' . $to . '"';
		}
		if ($post['type_balance'] == 'year') {
			$from = $post['year'] . "-1-1";
			$to =  $post['year'] . "-12-31";
			$where = 'date_of_earning BETWEEN "' . $from . '" AND "' . $to . '"';
		}
		$id = $_SESSION['id'];
		$stmt = $this->connection()->prepare("SELECT SUM(value) AS sum FROM earnings WHERE user_id = :id AND $where");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function getEarningsByType($type) 
	{
		$stmt = $this->connection()->prepare("SELECT SUM(value) AS sum FROM earnings WHERE type = :type AND user_id = :user_id");
		$stmt->bindParam(":type", $type, PDO::PARAM_STR);
		$stmt->bindParam(":user_id", $_SESSION['id'], PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		if ($result->sum == null) {
			$result->sum = 0;
			return $result;
		}
		return $result;
	}	
}