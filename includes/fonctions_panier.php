<?php

function creationPanier(){
	try{
		$db=new PDO('mysql:host=127.0.0.1;dbname=site-e-commerce','root','');
		$db->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	catch(Exception $e){

		die('une erreur est survenue' );
	}

	if(!isset($_SESSION['panier'])){

		$_SESSION['panier']=array();
		$_SESSION['panier']['libelleProduit']=array();
		$_SESSION['panier']['qteProduit']=array();
		$_SESSION['panier']['prixProduit']=array();
		$_SESSION['panier']['verrou']=false;

		$select=$db->query("SELECT tva FROM products ");
		$data=$select->fetch(PDO::FETCH_OBJ);
		

		$_SESSION['panier']['tva']=$data->tva;
		
		

	}
	return true;

}
function ajouterArticle($libelleProduit,$qteProduit,$prixProduit){
	if(creationPanier && !isVerouille()){
		$position_produit=array_search($libelleProduit,$_SESSION['panier']['libelleProduit']);
		if($position_produit !==false){
			$_SESSION['panier']['qteProduit'][$position_produit]+=$qteProduit;
		}else{
			array_push($_SESSION['panier']['libelleProduit'],$libelleProduit);
			array_push($_SESSION['panier']['qteProduit'],$qteProduit);
			array_push($_SESSION['panier']['prixProduit'],$prixProduit);
		}
	}else{
		echo 'Erreur veuillez contacter l\'administrateur';
	}

}
function ModifierQteProduit($libelleProduit,$qteProduit){
	if(creationPanier() && !isVerouille()){
		if($qteProduit>0){
			$position_produit=array_search($_SESSION['panier']['libelleProduit'],$libelleProduit);

				if($position_produit!==false){
					$_SESSION['panier']['qteProduit'][$position_produit] - $qteProduit;
				}
		}else{
			supprimerProduit($libelleProduit);
		}
	}else{
		echo 'Erreur veuillez contacter un administrateur';
	}
}

function supprimerArticle($libelleProduit){
	if(creationPanier() && !isVerouille()){
		$tmp=array();
		$tmp['libelleProduit']=array();
		$tmp['qteProduit']=array();
		$tmp['verrou']=$_SESSION['panier']['verrou'];

		for($i=0;$i<count($_SESSION['panier']['libelleProduit']);$i++){
			if($_SESSION['panier']['libelleProduit'][$i]!==$libelleProduit){
			array_push($_SESSION['panier']['libelleProduit'],$_SESSION['panier']['libelleProduit'][$i]);
			array_push($_SESSION['panier']['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
			array_push($_SESSION['panier']['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);

		}

	}
	$_SESSION['panier']=$tmp;

	unset($tmp);
}else{
	echo 'Erreur veuillez contacter votre administrateur';
}
}
function montantGlobal(){
	$total=0;
	for($i=0;$i<count($_SESSION['panier']['libelleProduit']);$i++){
		$total+=$_SESSION['panier']['qteProduit'][$i]*$_SESSION['panier']['prixProduit'][$i];
	}
	return $total;
}
function montantGlobalTVA(){
	$total=0;
	for($i=0;$i<count($_SESSION['panier']['libelleProduit']);$i++){
		$total+=$_SESSION['panier']['qteProduit'][$i]*$_SESSION['panier']['prixProduit'][$i];
	}
	return $total+$total*$_SESSION['panier']['tva']/100;
}
function supprimerPanier(){
	
		unset($_SESSION['panier']);
	}

function isVerrouille(){
	if(isset($_SESSION['panier']) && $_SESSION['panier']['verrou']){
		return true;

	}else{
		return false;
	}
}
	function compterArticles(){
		if(isset($_SESSION['panier'])){
			return count($_SESSION['panier']['libelleProduit']);
		}else{

			return 0;

		}

	}
	function CalculFraisPorts(){
		try{
		$db=new PDO('mysql:host=127.0.0.1;dbname=site-e-commerce','root','');
		$db->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}
	catch(Exception $e){

		die('une erreur est survenue' );
	}
		$max=200;
		$weight_product="";
		$shipping="";
		for($i =0 ;$i<compterArticles(); $i++){

          for($j = 0;$j<$_SESSION['panier']['qteProduit'][$i]; $j++){
          	$title =$_SESSION['panier']['libelleProduit'][$i];
          	$select=$db->query("SELECT weight FROM products WHERE title='$title'");
          	$result=$select->fetch(PDO::FETCH_OBJ);
          	$weight=$result->weight;
          	$weight_product=$weight*compterArticles();
          	$select=$db->query("SELECT * FROM weights WHERE name<= '$weight_product'");
          	$result2 = $select->fetch(PDO::FETCH_OBJ);
          	if($select->fetchColumn()){
          		$shipping=$result2->price;
          	}else{
          		$error=true;
          	}

          }
		}

		if($error){
			die('<br/><p style="color:red;">Supprimer l\'article et recommencez avec une quantité inferieure.</p>');
		}
		return $shipping;

	}



?>