<?php
require_once('includes/header.php');
require_once('includes/sidebar.php');

if(!isset($_SESSION['user_id'])){



if(isset($_POST['submit'])){
	$email=$_POST['email'];
	
	$pass=$_POST['password'];
	

	if($email&&$pass){

		$select=$db->query("SELECT id from users WHERE email='$email'");

		if($select->fetchColumn()){
			$select=$db->query("SELECT * from users WHERE email='$email'");
			$result=$select->fetch(PDO::FETCH_OBJ);
			$_SESSION['user_id']=$result->id;
			$_SESSION['user_name']=$result->username;
			$_SESSION['user_email']=$result->email;
			$_SESSION['password']=$result->password;
		}else{
			echo '<br/><h3 style="color:red;">Mauvais identifiants  </h3><br/>';

		}
		
			
	
		
	}else{
		echo '<br/><h3 style="color:red;">Veuillez remplir tout les champs</h3><br/>';

	}
}

?>
<br/>
<h1>	Se Connecter</h1><br/>

<form action="" method="POST">
	<h4>Email<input type="text" name="email"/></h4><br/>
	
	<h4>Mot de Passe<input type="password" name="password"/></h4><br/>
	
	<input type="submit" name="submit" value=" se connecter"/>
</form>
<a href="register.php">S'inscrire</a>
<br/>
<?php
}else{
	header('Location: my_account.php');
}
require_once('includes/footer.php');
?>