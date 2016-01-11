<?php

require 'expenses.php';
require_once 'DBconnect.php';

class ExpensesDB extends Expenses 
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
		$expense= new Expenses();
		$expense->exchangeArray($post);

		$user_id = $_SESSION['id'];
		$expense->setUser_id($user_id);

		$date_of_expense = date("Y-m-d");
		$expense->setDate_of_expense($date_of_expense);

		$type = $expense->getType();
		$expense->setType($type);

		$value=trim($expense->getValue());
		$expense->setValue($value);
       
	   	$_SESSION['value'] = $value;

	    if (empty($value)) {
			$errors['value'] = "Моля въведете разход!";
		}

		if (!is_numeric($value)) {
			$errors['value'] = "Моля въведете число!";
		}

		if (count($errors) > 0) {
			return $errors;
		} else { 
		     $this->add($expense);
		     return $errors = array();
		}	
	}

	public function add($object)
	{	
		$stmt = $this->connection()->prepare("INSERT INTO expenses(user_id, date_of_expense, type, value)
			VALUES(:user_id, :date_of_expense, :type, :value);");  
		$stmt->bindParam(':user_id', $object->getUser_id(), PDO::PARAM_INT);
		$stmt->bindParam(':date_of_expense', $object->getDate_of_expense(), PDO::PARAM_STR);
		$stmt->bindParam(':type', $object->getType(), PDO::PARAM_STR);
		$stmt->bindParam(':value', $object->getValue(), PDO::PARAM_INT);
		
		$stmt->execute();
	}

	public function select($id, $limit = null)
	{	
		if ($limit != null) {
			$stmt = $this->connection()->prepare("SELECT id, date_of_expense, type, value 
			FROM expenses WHERE user_id = :id ORDER BY date_of_expense DESC LIMIT :limit_expense;");
			$stmt->bindParam(':limit_expense', $limit, PDO::PARAM_INT);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		} else {
			$stmt = $this->connection()->prepare("SELECT id, date_of_expense, type, value 
			FROM expenses WHERE user_id = :id ORDER BY date_of_expense DESC;");
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_OBJ);
		}
	}

	public function update($id, $post)
	{
		$errors = array();
		$expense= new Expenses();
		$expense->exchangeArray($post);

		$type = $expense->getType();
		$expense->setType($type);

		$value=trim($expense->getValue());
		$expense->setValue($value);

		$expense->setId($id);

	    if (empty($value)) {
			$errors['value'] = "Моля въведете разход!";
		}

		if (!is_numeric($value)) {
			$errors['value'] = "Моля въведете число!";
		}

		if (count($errors) > 0) {
			return $errors;
		} else { 
		     $this->edit($expense);
		     return $errors = array();
		}	
	}

	public function isExpenseToUser($user_id, $expense_id)
	{
		$exists = false;
		$stmt = $this->connection()->prepare("SELECT id FROM expenses WHERE id = :expense_id 
											AND user_id = :user_id;");
		$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->bindParam(':expense_id', $expense_id, PDO::PARAM_INT);
		$stmt->execute();
		
		if ($stmt->fetch(PDO::FETCH_OBJ)) {
			$exists = true;
		}

		return $exists;
	}

	public function getData($id)
	{
		$stmt = $this->connection()->prepare("SELECT type, value FROM expenses WHERE id = :id;");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function edit($object)
	{
		$stmt = $this->connection()->prepare("UPDATE expenses SET value = :value, type = :type WHERE id = :id ;");
		$stmt->bindParam(':value', $object->getValue(), PDO::PARAM_INT);
		$stmt->bindParam(':type', $object->getType(), PDO::PARAM_STR);
		$stmt->bindParam(':id', $object->getId(), PDO::PARAM_INT);
		$stmt->execute();
	}

	public function toBulgarian($type)
	{
    	$toBG = array(
    		'food' 	 		 => 'Храна',
    		'fuel'			 => 'Гориво',
    		'entertainment'  => 'Забавление',
    		'education'      => 'Образование',
    		'other' 	     => 'Други'
    	);

        return $toBG[$type];
	}	

	public function delete($id)
	{
      $stmt=$this->connection()->prepare("DELETE FROM expenses WHERE id = :id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
	}

	public function getAllExpenses($post)
	{
		$where = '';
		if ($post['type_balance'] == 'day') {
			$day = $post['year'] . "-" . $post['month'] . "-" . $post['day'];
			$where = 'date_of_expense="' . $day . '"';
		}
		if ($post['type_balance'] == 'week') {
			$from = $post['from_year'] . "-" . $post['from_month'] . "-" . $post['from_day'];
			$to = $post['to_year'] . "-" . $post['to_month'] . "-" . $post['to_day'];
			$where = 'date_of_expense BETWEEN "' . $from . '" AND "' . $to . '"';
		}
		if ($post['type_balance'] == 'month') {
			$from = $post['year'] . "-" . $post['month'] . "-1";
			$to =  $post['year'] . "-" . $post['month'] . "-31";
			$where = 'date_of_expense BETWEEN "' . $from . '" AND "' . $to . '"';
		}
		if ($post['type_balance'] == 'year') {
			$from = $post['year'] . "-1-1";
			$to =  $post['year'] . "-12-31";
			$where = 'date_of_expense BETWEEN "' . $from . '" AND "' . $to . '"';
		}
		$id = $_SESSION['id'];
		$stmt = $this->connection()->prepare("SELECT SUM(value) AS sum FROM expenses WHERE user_id = :id AND $where");
		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	public function getExpensesByType($type) 
	{
		$stmt = $this->connection()->prepare("SELECT SUM(value) AS sum FROM expenses WHERE type = :type AND user_id = :user_id");
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