<?php
require_once('includes/header.php');

require_once('includes/sidebar.php');

require_once('includes/fonctions_panier.php');
$erreur=false;

$action=(isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:null));

if($action!==null){

	if(!in_array($action,array('ajout','suppression','refresh')))

		$erreur=true;
		$l=(isset($_POST['l'])?$_POST['l']:(isset($_GET['l'])?$_GET['l']:null));
$q=(isset($_POST['q'])?$_POST['q']:(isset($_GET['q'])?$_GET['q']:null));
$p=(isset($_POST['p'])?$_POST['p']:(isset($_GET['p'])?$_GET['p']:null));
$l=preg_replace('#\v#','',$l);
$p=floatval($p);
if(is_array($q)){
	$QteProduit=array();
	$i=0;
	foreach ($q as $contenu) {

		$QteProduit[$i++] =intval($contenu);
	}
		
	}else{
		$q=intval($q);
	
}
}



if($erreur){
	switch ($action) {
		Case 'ajout':
		ajouterArticle($l,$q,$p);
			
			break;
			Case "suppression":
			supprimerArticle($l);
		    
		    break;
			Case "refresh":
			for($i=0;$i<count($QteProduit);$i++){
				modifierQteArticle($_SESSION['panier']['libelleProduit'][$i], round($QteProduit));
			}

			break;

			Default;
		
			break;
	}
}

?>
<form method="post" action="">
	<table width ="400">
		<tr>
			<td colspan="4">Votre panier</td>
		</tr>
		<tr>
			<td>Libelle produit</td>
			<td>Prix Unitaire</td>
			<td>Quatite</td>
			<td>TVA</td>
			<td>Action</td>
		</tr>
		<?php

		if(isset($_GET['deletepanier']) && $_GET['deletepanier']==true){
			supprimerPanier();
		}

	if(creationPanier()){

		$nbProduits=isset($_SESSION['panier']['libelleProduit']);

		if($nbProduits<=0){

	echo '<br><p style="color:Red;">Oops,panier vide !</p>';

}else{
    for($i=0;$i<$nbProduits;$i++){
    	?>
    	<tr>
    		<td><br/><?php echo isset($_SESSION['panier']['libelleProduit'][$i]); ?></td>
    		
    		
    		<td><br/><?php echo isset($_SESSION['panier']['prixProduit'][$i]); ?></td>
    		<td><br/><input type="" name="q[]" value="<?php echo isset($_SESSION['panier']['qteProduit'][$i]); ?>"size="5"></td>
    		<td><br/><?php echo isset($_SESSION['panier']['tva'])." %"; ?></td>
    		<td><br/><a href="panier.php?action=suppression&amp;l=<?php echo rawurlencode($_SESSION['panier']['libelleProduit'][$i]); ?>">X</a></td>
    	</tr>
    <?php }
    ?>
    	<tr>
    		<td colspan="2"><br/>
    			<p>Total :<?php echo montantGlobal(). "francs"; ?></p><br/>
    			<p>Total avec TVA  :<?php echo montantGlobalTVA(). "francs"; ?></p><br/>
    			<p>Calcul des frais de port : </p>

    		</td>
    		</td>
    	</tr>



    	</tr>
    	<td colspan="4">
    		<input type="submit" name="" value="rafraichir"/>
    		<a href="?deletepanier=true">Supprimer le panier</a>
    	</td>
    	<?php
    
}
}
?>
</table>
</form>
<?php

require_once('includes/footer.php');
?>