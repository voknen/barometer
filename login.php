<?php
session_start();
if(isset($_SESSION['isLogged'])){
	header("Location: index.php");
	exit();
}
require 'userDB.php';
$errors=array();

?>
<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="css/style.css">
	    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	    <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
	    <script type="text/javascript" src="js/javascript.js"></script>
		<meta charset="UTF-8">
		<meta charset="UTF-8">
		<title>Log in</title>
	</head>
		<body>
			<div class="flex-container">
				<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
					<?php 
	                    $user = new UserDB();
	                    $errors = $user->login($_POST);
	                ?>
					<?php if (count($errors) == 0) : ?>
	                    <?php
	                        header("Location: index.php");
	                        exit();
	                    ?>
	               	<?php endif; ?>
	            <?php endif;?>
	            <h1>Влизане</h1>
				<form action="" method="post" enctype="multipart/form-data">
					<ul>
						<div class="flex-item">
							<li>
								<label for="name"> Потребителско име </label>
								<input type="text" class="info" name="username" value= "<?= (isset($_SESSION['username']) ? $_SESSION['username'] : "" )?>"/>
								<?php if (isset($errors['username'])) : ?>
								<p>
									<?= $errors['username']; ?>
						       	</p>
						    <?php endif; ?>

							<li>
								<label for="name"> Парола </label>
								<input type="password" class="info" name="password" value= "<?= (isset($_SESSION['password']) ? $_SESSION['password'] : "" )?>"/>
								<?php if (isset($errors['password'])) : ?>
								<p>
									<?= $errors['password']; ?>
						       	</p>
						       	<?php endif; ?>
							</li>

							<li>
								<input class="form-submit" type="submit" name="submit" value="Влез"/>
							</li>
							<li>
								<a href="register.php"> Регистрация </a> 
                        	</li>
						</div>
					</ul>
				</form>
            </div>
		</body>
</html>