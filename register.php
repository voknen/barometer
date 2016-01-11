<?php
session_start();
if(isset($_SESSION['isLogged'])){
	header("Location: index.php");
	exit();
}
$errors=array();
require 'userDB.php';
$success = false;
?>

<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="css/style.css">
	    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	    <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
	    <script type="text/javascript" src="js/javascript.js"></script>
		<meta charset="UTF-8">
		<title> Register </title>
			
		<body>
		<div class="flex-container">
			<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
	            <?php
	                $user = new UserDB();
	                $errors = $user->register($_POST);
	            ?>
	            <?php if (count($errors) == 0) : ?>
	                <?php $success = true; ?>
	            <?php endif; ?>
	        <?php endif; ?>	
            <h1>Регистрация</h1>
			<form action="" method="POST">
				<ul>
					<div class="flex-item">
						<li>
							<label for="first_name"> Име </label>
							<input type="text" class="info" name="first_name" value= "<?= (isset($_SESSION['first_name']) ? $_SESSION['first_name'] : "" )?>"/>
							<?php if (isset($errors['first_name'])) : ?>
								<p>
				 					<?= $errors['first_name']; ?>
						       	</p>
					    	<?php endif; ?>
						</li>

	                    <li>
							<label for="last_name"> Фамилия </label>
							<input type="text" class="info" name="last_name" value= "<?= (isset($_SESSION['last_name']) ? $_SESSION['last_name'] : "" )?>"/>
							<?php if (isset($errors['last_name'])) : ?>
								<p>
				 					<?= $errors['last_name']; ?>
						       	</p>
					        <?php endif; ?>
						</li>
                    
                		<li>
							<label for="age"> Възраст </label>
							<input type="text"  class="info" name="age" value= "<?= (isset($_SESSION['age']) ? $_SESSION['age'] : "" )?>"/>
							<?php if (isset($errors['age'])) : ?>
								<p>
									<?= $errors['age']; ?>
						       	</p>
					        <?php endif; ?>
						</li>
	                    <li>
							<label for="username"> Потребителско име </label>
							<input type="text" class="info" name="username" value= "<?= (isset($_SESSION['username']) ? $_SESSION['username'] : "" )?>"/>
							<?php if (isset($errors['username'])) : ?>
								<p>
									<?= $errors['username']; ?>
						       	</p>
					        <?php endif; ?>
						</li>
						<li>
							<label for="password"> Парола </label>
							<input type="password" class="info" name="password" value= "<?= (isset($_SESSION['password']) ? $_SESSION['password'] : "" )?>"/>
							<?php if (isset($errors['password'])) : ?>
								<p>
									<?= $errors['password']; ?>
						       	</p>
					        <?php endif; ?>
					   </li>

						<li>
							<input class="form-submit" type="submit" value="Регистрирай" name="Регистрирай" >
							<a id="login_link" href="login.php"> Влизане </a> 
						</li> 
						<li>
							<?php if ($success) : ?>
								<p>Регистрацията е успешна!</p>
							<?php endif;?>
						</li> 
					</div>
				</ul>
			</form>
		</div>
		</body>
</html>