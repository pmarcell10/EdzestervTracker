<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] < 1) : ?>
	<p>No permission.</p>
<?php else : ?>

	<?php 
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addItem'])) {
		$p_data = [
			'cpu' => $_POST['cpu'],	
			'gpu' => $_POST['gpu'],
			'ram' => $_POST['ram'],
			'ssd' => $_POST['ssd'],
			'os'  => $_POST['os'],
			'price' => $_POST['price'],
			'descr' => $_POST['desc']		
		];

			$query = "INSERT INTO items (cpu, gpu, ram, ssd, os, price, userid, descr) VALUES (:cpu, :gpu, :ram, :ssd, :os, :price, :userid, :descr)";
			$params = [
				':cpu' => $p_data['cpu'],
				':gpu' => $p_data['gpu'],
				':ram' => $p_data['ram'],
				':ssd' => $p_data['ssd'],
				':os'  => $p_data['os'],
				':price' => $p_data['price'],
				':userid' => $_SESSION['uid'],
				':descr' => $p_data['descr']
			];

			require_once DATABASE_CONTROLLER;

			if(!executeDML($query, $params)){
				echo "Cant insert.";
			}
			header('Location: index.php?P=browse');
	 }
	 ?>

	<form method="POST">
		<div class="form-row">
			<div class="form-group col-md-12">
				<input type="text" class="form-control" id="cpu" name="cpu" placeholder="CPU">
			</div>
			<div class="form-group col-md-12">
				<input type="text" class="form-control" id="gpu" name="gpu" placeholder="GPU">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<input type="text" class="form-control" id="ram" name="ram" placeholder="RAM">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
		    	<input type="text" class="form-control" name="ssd" id="ssd" placeholder="SSD" >
		  	</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<input type="text" class="form-control" id="os" name="os" placeholder="OS">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<input type="text" class="form-control" id="price" name="price" placeholder="PRICE">
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-12">
				<input type="text" class="form-control" id="desc" name="desc" placeholder="DESCRIPTION">
			</div>
		</div>

		<div class="btncenter">
			<button type="submit" class="btn btn-primary btncenter" name="addItem">Add Item</button>
		</div>

	</form>






<?php endif; ?>