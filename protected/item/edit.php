<h3><center>Edit Item</center></h3>

<?php 
		$id = $_GET['id'];
	 	$query = "SELECT * FROM items WHERE id=:id";
	 	$params = [':id' => $id];
	 	require_once DATABASE_CONTROLLER;
	 	$result = getRecord($query,$params);
?>

<?php 
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editItem'])){
		$query = "UPDATE items SET cpu = :cpu, gpu = :gpu, ram = :ram, ssd = :ssd, os = :os, price = :price, descr = :descr WHERE id = :id";
		$params = [
			':cpu' => $_POST['cpu'],
			':gpu' => $_POST['gpu'],
			':ram' => $_POST['ram'],
			':ssd' => $_POST['ssd'],
			':os' => $_POST['os'],
			':price' => $_POST['price'],
			':descr' => $_POST['descr'],
			':id' => $_GET['id']
		];
		if(!executeDML($query, $params)){
			echo 'Failed to edit.';
		}
		header('Location: index.php?P=browse');
	}

 ?>

	<p><center>Item ID: <b><?=$result['id'] ?></b></center></p>
	 <form method="POST">
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="cpu"><b>CPU: </b></label>
				<input type="text" class="form-control" id="cpu" name="cpu" value="<?=$result['cpu'] ?>">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="cpu"><b>GPU: </b></label>
				<input type="text" class="form-control" id="gpu" name="gpu" value="<?=$result['gpu'] ?>">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="cpu"><b>RAM: </b></label>
				<input type="text" class="form-control" id="ram" name="ram" value="<?=$result['ram'] ?>">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="cpu"><b>SSD: </b></label>
		    	<input type="text" class="form-control" name="ssd" id="ssd" value="<?=$result['ssd'] ?>" >
		  	</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="cpu"><b>OS: (0: No OS, 1: Windows 10) </b></label>
				<input type="text" class="form-control" id="os" name="os" value="<?=$result['os'] ?>">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="cpu"><b>PRICE:  </b></label>
				<input type="text" class="form-control" id="price" name="price" value="<?=$result['price'] ?>">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="cpu"><b>DESCRIPTION: </b></label>
				<input type="text" class="form-control" id="descr" name="descr" value="<?=$result['descr'] ?>">
			</div>
		</div>

		<div class="btncenter">
			<button type="submit" class="btn btn-primary btncenter" name="editItem">Edit Item</button>
		</div>

	</form>
