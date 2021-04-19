<h1 style="text-align: center"> Browse our items.</h1>

<?php 
	$query = "SELECT id, cpu, gpu, ram, ssd, price, os, descr, userid FROM items";
	require_once DATABASE_CONTROLLER;
	$items = getList($query);
?>

<?php 
	if(isset($_GET['buyid']) && $_GET['buyid'] != ''){
		if (!IsUserLoggedIn()) {
			header('Location: index.php?P=register&req_reg=1');
		}
		else{
			$buy_query = "INSERT INTO orders (itemid, userid) VALUES (:itemid, :userid)";
			$buy_params = [
					':itemid' => $_GET['buyid'],
					':userid' => $_SESSION['uid']
			];
			if(!executeDML($buy_query, $buy_params)){
				header('Location: index.php');
			}
			
			$getorderquery = "SELECT MAX(id) FROM orders WHERE itemid = :itemid AND userid = :userid ";
			$getorderparams = [':itemid' => $_GET['buyid'],
							   ':userid' => $_SESSION['uid']];
			$lastorderquery = getRecord($getorderquery, $getorderparams);
			header('Location: index.php?order='.$lastorderquery['MAX(id)']);
		}
	}
 ?>



<?php if(count($items) <= 0) : ?>
	<h2>No items found.</h2>
<?php else : ?>	
	<?php foreach ($items as $i) : ?>
		<div class="item">
				<table style="table-layout: fixed; width: 100%; border: 3px solid gray">
				<tr>
					<td><b>CPU:</b> <?=$i['cpu'] ?></td>
					<td rowspan="5" style="text-align: center">
						<img src="./public/pc.png" width=50% style="margin-top: 6px; margin-bottom: 6px">
						<?php if($i['descr'] == '') : ?>
							No description.
						<?php else : ?>
							<?=$i['descr'] ?>
						<?php endif; ?>
						<?php if (isset($_SESSION['uid']) && $_SESSION['uid'] == $i['userid']) : ?>
							<br>
							<small><i>Your PC.</i></small>
						<?php endif; ?>
					</td>	
				</tr>
				<tr>
					<td><b>GPU:</b> <?=$i['gpu'] ?></td>			
				</tr>
				<tr>
					<td><b>RAM:</b> <?=$i['ram'] ?> GB</td>
				</tr>
				<tr>
					<td><b>SSD:</b> <?=$i['ssd'] ?> GB</td>
				</tr>
				<tr>
					<td><b>OS: </b>
						<?php if($i['os'] == 0) : ?>
							No OS.
						<?php else : ?>
							Windows 10
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td><b>Price:</b> <?=$i['price'] ?> Ft</td>
					<td>
						<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] < 1 || ($_SESSION['uid'] != $i['userid']) && !IsUserAdmin()) : ?>
							<a href="index.php?P=browse&buyid=<?=$i['id']?>"><p style="font-size: 22px"><center>Buy</center></p></a>
						<?php else : ?>
							<center>
								<a href="index.php?P=edit_item&id=<?=$i['id']?>">Edit</a>
								<span> &nbsp; | &nbsp; </span>
								<a href="index.php?P=delete&del_id=<?=$i['id']?>">Delete</a>
							</center>
						<?php endif; ?>
					</td>
				</tr>
			</table>
		</div>
		<hr>
	<?php endforeach; ?>
<?php endif; ?>