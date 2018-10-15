<?php
session_start();
$user= 'Ridial';
$pass='123456';
    if(isset($_POST['submit'])){
    	$username= $_POST['username'];
    	$password= $_POST['password'];

    	if($username && $password){

    	if($username==$user&&$password==$pass){
    			$_SESSION['username']=$username;
    			header('Location: admin.php');

    		

    	}
    	else{
    		echo 'Identifiant erroné';
    	}



    }else{
    	echo 'Veuillez remplir tout les champs';
    }
}
?>
<link rel="stylesheet" href="../styles/bootstrap.min.css" >
<h1>Administration-Connexion</h1>
<form action="" method="POST">
	<h3>Pseudo</h3>
	<input type="text" name="username"></br></br>
	<h3>Mot de Passe</h3>
	<input type="password" name="password"></br></br>
	<input type="submit" name="submit"></br></br>
</form>