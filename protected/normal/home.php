<html>
<?php if(!isset($_SESSION['uid'])) : ?>	
	<h2><center>Üdv az oldalon!</center></h2>
	<center><p><a href="index.php?P=register">Regisztrálj</a>, vagy <a href="index.php?P=login">jelentkezz be</a> az edzésterved követéséhez.</p></center>	
<?php else : ?>
	<?php if($_SESSION['terv_set'] == 0) : ?>
		<center><p style="font-size: 140%"><b>Üdv, <?=$_SESSION['lname']; ?></b></p></center>
		<center><p>Még nincs hozzáadott edzésterved.</p></center>
		<center><p><a href="index.php?P=add_terv">Adj hozzá</a> egyet!</p></center>
	<?php else: ?>
		<?php if(array_key_exists('add_success', $_GET) && $_GET['add_success'] == 1) : ?>
			<p><center>Sikeresen hozzáadtad az edzéstervet!</center></p>
		<?php endif; ?>
		<?php 
			include_once PROTECTED_DIR.'edzesek/show.php';
		 ?>
	<?php endif; ?>
<?php endif; ?>
</html>