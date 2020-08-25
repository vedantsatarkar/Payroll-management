<?php
require_once "pdo.php";
session_start();

$error=false;
if(isset($_SESSION['error'])){
	$error=htmlentities($_SESSION['error']);
	unset($_SESSION['error']);
}

$salt = 'XyZzy12*_';
if(isset($_POST['email'])&&isset($_POST['pass'])){
	if(strlen($_POST['email'])==0||strlen($_POST['pass'])==0){
		$_SESSION['error']='All fields are required';
		header('Location: index.php');
		return;
	}

	$email=htmlentities($_POST['email']);
	$pass=htmlentities($_POST['pass']);
	$stmt=$pdo->prepare('SELECT * FROM users WHERE email = :email AND password = :pass');
    $stmt->execute([
        ':email'=>$email,
        ':pass'=>hash('md5',$salt.$pass),
    ]);
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row!==false){
        error_log('Login success '.$email);
       	$_SESSION['name']=$row['name'];
       	$_SESSION['user_id']=$row['user_id'];
        header('Location: home.php?user_id='.$_SESSION['user_id']);
        return;
    }
	else{
		$_SESSION['error']='Please try again';
		error_log('Login fail '.$pass.' $check');
		header('Location: index.php');
		return;
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/index.css">
	</head>
	<body>
		<!--<h1>Employee Management System</h1>
		<h2>Please enter valid credentials</h2>-->
		<?php 
		echo('<p style="color:red">'.$error.'</p>');
		?>
	
		<div class="index-container" >
			<div class="form-div">
				<form method="post" class="login-form">
					
					<b>Email</b>
					<br>
					<input type="email" name="email" placeholder="abc@xyz.com" id="index_email" >
					<br>
					<b>Password</b>
					<br>
					<input type="password" name="pass" id="index_pwd" >
					<br>
					<button type="submit" name="login" value="Login" class="btn">Login</button>
					<br>
					<button type="submit" formaction="index.php" class="btn cancel">Cancel</button>
				</form>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
	</body>
</html>