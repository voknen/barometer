<?php
session_start();

if (!isset($_SESSION['isLogged'])) {
	header("Location: login.php");
	exit();
}

require 'expensesDB.php';
$last_expenses = (new ExpensesDB())->select($_SESSION['id']);
?>

<html>

<head>
	<link type="text/css" rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="js/javascript.js"></script>
	<meta charset="UTF-8">
	<title> Index </title>
</head>
	<body>
		<div class="mymenu">
	    </div>
		<div>
	    	<a class="add" href="add_expense.php">Добави разход</a>
	    	<table>
	    		<th>Дата</th>
	    		<th>Тип</th>
	    		<th>Стойност</th>
	    		<th>Промяна</th>
	    		<th>Изтриване</th>
			    <?php foreach ($last_expenses as $last_expense) : ?>
					<tr>
						<td><?= date("F j, Y", strtotime($last_expense->date_of_expense)); ?></td>
						<td><?= (new ExpensesDB())->toBulgarian($last_expense->type); ?></td>
						<td><?= $last_expense->value; ?></td>
						<td><a class="change" href="edit_expense.php?expense=<?= $last_expense->id; ?>">промени</a></td>
						<td><a class="delete" href="delete_expense.php?expense=<?= $last_expense->id;?>" 
							onclick = "return confirm('Наистина ли искате да изтриете този разход?')">изтрий</a></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</body>
</html>