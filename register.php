<?php
require_once('includes/header.php');
require_once('includes/sidebar.php');

if(!isset($_SESSION['user_id'])){

if(isset($_POST['submit'])){
	$username=$_POST['username'];
	$email=$_POST['email'];
	$pass=$_POST['password'];
	$repeat=$_POST['repeatpassword'];
	

	if($username&&$email&&$pass&&$repeat){
		if($pass==$repeat){
			$db->query("INSERT INTO users VALUES('','$username','$email','$pass')");
			echo '<br/><h3 style="color:green;">Compte crèé avec succès.<a href="connect.php">connectez vous</h3><br/>';
		}
		else{
			echo '<br/><h3 style="color:red;">Les mots de passes ne sont pas identiques.</h3><br/>';
		}
		
	}else{
		echo '<br/><h3 style="color:red;">Veuillez remplir tout les champs</h3><br/>';

	}
}

?>
<br/>
<h1>S'enregistrer</h1><br/>

<form action="" method="POST">
	<h4>Pseudo<input type="text" name="username"/></h4><br/>
	<h4>Email<input type="email" name="email"/></h4><br/>
	<h4>Mot de Passe<input type="password" name="password"/></h4><br/>
	<h4>Confirmez Mot de passe<input type="password" name="repeatpassword"/></h4><br/>
	<input type="submit" name="submit" value="connecter"/>
</form>
<a href="connect.php">Se connecter</a>
<br/>
<?php
}else{
	header('Location:my_account.php');
}

require_once('includes/footer.php');
?>