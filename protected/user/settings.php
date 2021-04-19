<h2><center>Felhasználói beállítások</center></h2>
<hr>

<?php if(array_key_exists('ae_success', $_GET) && $_GET['ae_success'] == 1) : ?>
		<center><p>Sikeresen hozzáadtad az edzésed!</p></center>
<?php endif; ?>

<?php 
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])){
		require_once DATABASE_CONTROLLER;
		$query = "UPDATE users SET fname = :fname, lname = :lname, email = :email, berletid = :berletid, rotation = :rotation WHERE id = :id";
		$params =[
			':fname' => $_POST['first_name'],
			':lname' => $_POST['last_name'],
			':email' => $_POST['email'],
			':berletid' => $_POST['BerletId'],
			':rotation' => (int)$_POST['rotation'],
			':id' => $_SESSION['uid']
		];
		if(!executeDML($query,$params)){
			echo 'Sikertelen módosítás!';
		}
		else{
			if(IsBerletValid($_POST['BerletId'])){
				$query = "INSERT INTO berlet (berletid, tipus, vasarlas, alkalmak, ervenyes) VALUES (:berletid, :tipus, :vasarlas, :alkalmak, :ervenyes)";
				$params = [
					':berletid' => $_POST['BerletId'],
					':tipus' => "",
					':vasarlas' => "",
					':alkalmak' => "",
					':ervenyes' => ""
				];
				executeDML($query,$params);
			}
			refreshSession();
			header('Location: index.php?edit_success=1');
		}
	}

 ?>

<center><a href="index.php?P=edit"><button class="btn btn-primary col-md-12" name="editTerv" style="margin-bottom: 16px">Edzésterv módosítása</button></center></a>
<center><a href="index.php?P=edzesfajta&ref=settings"><button class="btn btn-primary col-md-12" name="editTerv">Saját edzésfajták módosítása</button></center></a>

<hr>

<h4><center>Adataim módosítása:</center></h4>

<form method="post">
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="FirstName">Vezetéknév</label>
			<input type="text" class="form-control" id="FirstName" name="first_name" value="<?=$_SESSION['fname']; ?>">
		</div>
		<div class="form-group col-md-6">
			<label for="LastName">Keresztnév</label>
			<input type="text" class="form-control" id="LastName" name="last_name" value="<?=$_SESSION['lname']; ?>">
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="Email">Email</label>
			<input type="email" class="form-control" id="Email" name="email" value="<?=$_SESSION['email']; ?>">
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="BerletId">Cutler Bérlet Azonosító:</label>
			<input type="text" class="form-control" id="BerletId" name="BerletId" value="<?=$_SESSION['berletid']; ?>">
		</div>
	</div>

	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="rotation">Edzésterv frissítése:</label>
			<select class="form-group col-md-12" id="rotation" name="rotation">
				<?php 
					$current = $_SESSION['rotation'];
				 ?>
			    <option value="1" <?php if($current==1) : ?> selected="selected" <?php endif; ?>>Bérlet alapú</option>
			    <option value="2" <?php if($current==2) : ?> selected="selected" <?php endif; ?>>Manuális</option>
			 </select>
		</div>
	</div>

	<center><button type="submit" class="btn btn-primary" name="edit">Módosítás</button></center>
</form>