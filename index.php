<?php
session_start();

if (!isset($_SESSION['isLogged'])) {
	header("Location: login.php");
	exit();
}

require 'earningsDB.php';
$last_earnings = (new EarningsDB())->select($_SESSION['id'], 5);

require 'expensesDB.php';
$last_expenses = (new ExpensesDB())->select($_SESSION['id'], 5);
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
	    	<a class="add" href="add_earning.php">Добави приход</a>
	    	<table>
	    		<th>Дата</th>
	    		<th>Тип</th>
	    		<th>Стойност</th>
	    		<th>Промяна</th>
			    <?php foreach ($last_earnings as $last_earning) : ?>
					<tr>
						<td><?= date("F j, Y", strtotime($last_earning->date_of_earning)); ?></td>
						<td><?= (new EarningsDB())->toBulgarian($last_earning->type); ?></td>
						<td><?= $last_earning->value; ?></td>
						<td><a class="change" href="edit_earning.php?earning=<?= $last_earning->id; ?>">промени</a></td>						
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<div>
	    	<a class="add" href="add_expense.php">Добави разход</a>
	    	<table>
	    		<th>Дата</th>
	    		<th>Тип</th>
	    		<th>Стойност</th>
	    		<th>Промяна</th>
			    <?php foreach ($last_expenses as $last_expense) : ?>
					<tr>
						<td><?= date("F j, Y", strtotime($last_expense->date_of_expense)); ?></td>
						<td><?= (new ExpensesDB())->toBulgarian($last_expense->type); ?></td>
						<td><?= $last_expense->value; ?></td>
						<td><a class="change" href="edit_expense.php?expense=<?= $last_expense->id; ?>">промени</a></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</body>
</html>