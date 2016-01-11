<?php
session_start();
if (!isset($_SESSION['isLogged'])) {
	header("Location: login.php");
	exit();
}
$errors=array();
$success = false;
require 'earningsDB.php';
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
    <div class="add-container">
		<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
	        <?php
	            $earning = new EarningsDB();
	            $errors = $earning->insert($_POST);
	        ?>
	        <?php if (count($errors) == 0) : ?>
	       		 <?php $success = true; ?>
	        <?php endif; ?>
	    <?php endif; ?>
		<form method="post" action="">
			<div class="add-item">
				<label for="type_earning"> Изберете тип приход</label><br>
				<select class="info" name="type_earning">
				    <option value="salary"> Заплата </option>
				  	<option value="scholarship"> Стипендия </option>
				  	<option value="inheritance"> Наследство </option>
				  	<option value="other"> Други </option>
				</select></br>
				<label  for="value"> Добавете приход </label><br>
				<input  class="info" type="text" name="value" value="<?= isset($_SESSION['value']) ? $_SESSION['value'] : '' ?>"><br>
			 	<?php if (isset($errors['value'])) : ?>
					<p>
	 					<?= $errors['value']; ?>
			       	</p>
		    	<?php endif; ?>
			 	<input class="form-submit" type="submit" value="Добавяне">
                <?php if($success): ?>
			 		<p> Успешно добавени </p>
			 	<?php endif; ?>
			</div>
		</form>
	</div>
</body>
</html>