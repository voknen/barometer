<?php
session_start();
if (!isset($_SESSION['isLogged'])) {
	header("Location: login.php");
	exit();
}
$errors=array();
$success = false;
require 'expensesDB.php';
?>
<html>
<head>
	<meta charset="UTF-8">
	<link type="text/css" rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="js/javascript.js"></script>
	<title></title>
</head>
<body>
	<div class="mymenu">
    </div>
    <?php if (is_numeric($_GET['expense']) && (new ExpensesDB())->isExpenseToUser($_SESSION['id'], $_GET['expense'])) : ?>
	    <?php $expense_data = (new ExpensesDB())->getData($_GET['expense']); ?>
	    <div class="add-container">
			<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
		        <?php
		            $expense = new ExpensesDB();
		            $errors = $expense->update($_GET['expense'], $_POST);
		        ?>
		        <?php if (count($errors) == 0) : ?>
		            <?php 
		            	$success=true;
		            	$expense_data = (new ExpensesDB())->getData($_GET['expense']);
		            ?>
		        <?php endif; ?>
		    <?php endif; ?>

			<form method="post" action="">
				<div class="add-item">
					<label for="type_expense"> Изберете тип разход</label><br>
					<select class="info" name="type_expense">
					    <option value="food" <?= $expense_data->type == 'food' ? 'selected' : '';?>> Храна </option>
					  	<option value="fuel" <?= $expense_data->type == 'fuel' ? 'selected' : '';?>> Гориво </option>
					  	<option value="entertainment" <?= $expense_data->type == 'entertainment' ? 'selected' : '';?>> Забавление </option>
					  	<option value="education" <?= $expense_data->type == 'education' ? 'selected' : '';?>> Образование </option>
					  	<option value="other" <?= $expense_data->type == 'other' ? 'selected' : '';?>> Други </option>
					</select></br>
					<label  for="value"> Променете разход </label><br>
					<input  class="info" type="text" name="value" value="<?= $expense_data->value; ?>"><br>
					<?php if (isset($errors['value'])) : ?>
						<p>
		 					<?= $errors['value']; ?>
				       	</p>
			    	<?php endif; ?>
				 	<input class="form-submit" type="submit" value="Промени">
				 	<?php if($success): ?>
				 		<p> Успешно променен </p>
				 	<?php endif; ?>
			    </div>
			</form>
		</div>
	<?php else : ?>
		<p>Избрали сте грешен линк!</p>
	<?php endif; ?>
</body>
</html>