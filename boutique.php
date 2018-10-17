<?php
	require_once('includes/header.php');

	require_once('includes/sidebar.php');

	if(isset($_GET['show'])){

		$product=$_GET['show'];
		$select=$db->prepare("SELECT * FROM products WHERE title='$product'");	
		$select->execute();	


        $s->$select->fetch(PDO::FETCH_OBJ);

        ?>
        <br/><div style="text-align:center;">
        	<img src="admin/imgs/<?php echo $s->title;?>.jpg"/>
        <h1><?php echo $s->title; ?></h1>
        <h5><?php echo $s->description; ?></h5>

    </div>

        <?php

	}else{

	if(isset($_GET['category'])){
			$category=$_GET['category'];
			$select=$db->prepare("SELECT * FROM products WHERE category='$category'");	
		$select->execute();	
		while($s=$select->fetch(PDO::FETCH_OBJ)){
			$lenght=255;

		$description=$s->description;

		$new_description=substr($description,0,$lenght)."...";
		$description_finale=wordwrap($new_description,25,'<br/>',false);

			?>
			<br/><br/>
			<a href="?show=<?php echo $s->title; ?>"><img src="admin/imgs/<?php echo $s->title; ?>.jpg"/>
			<a href="?show=<?php echo $s->title; ?>"><h2><?php echo $s->title; ?></h2>
			<h5><?php echo $s->description; ?></h5>
			<h4><?php echo $s->price; ?>Francs</h4>
			 
			<?php if($s->stock!=0){?><a href="panier.php?>action=ajout&amp;l=<?php echo $s->title; ?>&amp;q=1<?php echo $s->stock; ?>&amp;p=<?php echo$s->price; ?>">Ajouter au panier</a><?php }else{
				echo'<h5 style="color:red;"Stock epuise </h5>'; }?>
			
			<br/><br/>
			<?php
		}
		?>
<br/><br/><br/><br/>
<?php
}else{



	$select=$db->query("SELECT * FROM category");
	while($s=$select->fetch(PDO::FETCH_OBJ)){
		?>
		<a href="?category=<?php echo $s->name;?>"><h3><?php echo $s->name ?></h3></a> 
		<?php
	}
}
	}
	
	require_once('includes/footer.php');
?>
