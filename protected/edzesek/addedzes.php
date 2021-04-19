<?php
	require_once DATABASE_CONTROLLER;
	$query = "SELECT nev FROM s_edzesek WHERE userid = :userid";
	$params =[':userid' => $_SESSION['uid']];
	$s_edzesek = getList($query,$params);
?>
<?php  
	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addEdzesFajta'])){
		
		$query = "SELECT nev FROM s_edzesek WHERE userid = :userid AND nev = :nev";
		$params = [':userid' => $_SESSION['uid'], ':nev' => $_POST['edzesFajta']];
		$result = getRecord($query,$params);
		//
		$query = "SELECT nev FROM edzesek";
		$params = [];
		$edzesek = getList($query,$params);
		//
		$edzesnevek = array();
		foreach($edzesek as $e){
			array_push($edzesnevek,$e['nev']);
		}
		if(!empty($result) || in_array($_POST['edzesFajta'], $edzesnevek) || $_POST['edzesFajta'] == ""){
			if(!empty($result)){
				echo "Már szerepel egy ilyen edzésfajtád!";
			}
			else if(in_array($_POST['edzesFajta'], $edzesnevek)){
				echo "Ez egy alap edzésfajta!";
			}
			else if($_POST['edzesFajta'] == ""){
				echo "Nem adhatsz hozzá üres edzésfajtát!";
			}
		}	
		else{
			$query = "INSERT INTO s_edzesek (userid, nev) VALUES (:userid, :nev)";
			$params = [':userid' => $_SESSION['uid'], ':nev' => $_POST['edzesFajta']];
			if(!executeDML($query,$params)){
				echo "Sikertelen hozzáadás!";
			}
			else{
				echo "Sikeresen hozzáadtad a következő edzést: ".$_POST['edzesFajta'];
				$query = "SELECT nev FROM s_edzesek WHERE userid = :userid";
				$params =[':userid' => $_SESSION['uid']];
				$s_edzesek = getList($query,$params);
			}
		}
	}
?>

<?php if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['removeEdzesFajta'])){
		$query = "DELETE FROM s_edzesek WHERE nev = :nev AND userid = :userid";
		$params = [':nev' => $_POST['removeEdzes'], ':userid' => $_SESSION['uid']];
		if(executeDML($query,$params)){
			echo "Sikeresen törölted a következő edzést: ".$_POST['removeEdzes'].". Frissítsd a terved, ha nem szeretnéd, hogy többet megjelenjen.";
		}

		$query = "SELECT nev FROM s_edzesek WHERE userid = :userid";
		$params =[':userid' => $_SESSION['uid']];
		$s_edzesek = getList($query,$params);
	}
?>

<?php if(array_key_exists('ref', $_GET) && $_GET['ref']=="add") : ?>
	<p><a href="index.php?P=add_terv">&lt; Vissza</a></p>
<?php elseif(array_key_exists('ref', $_GET) && $_GET['ref']=="edit") : ?>
	<p><a href="index.php?P=edit">&lt; Vissza</a></p>
<?php elseif(array_key_exists('ref', $_GET) && $_GET['ref']=="settings") : ?>
	<p><a href="index.php?P=settings">&lt; Vissza</a></p>
<?php endif; ?>

<form method="POST">
	<label for="addEdzesFajta" style="font-size: 120%"><u>Add meg az új edzésfajtádat!:</u></label>
	<input style="margin-bottom: 16px" type="text" class="form-control" id="addEdzesFajta" name="edzesFajta" placeholder="Pl. funkcionális, küzdő">
	<center><button type="submit" class="btn btn-primary" name="addEdzesFajta">Hozzáadás</button></center>
</form>

<form method="POST">
	<label for="removeEdzesFajta" style="font-size: 120%"><u>Itt törölhetsz saját edzést!:</u></label>
	<?php if(empty($s_edzesek)) : ?>
		<center><p>Nincs saját edzésed!</p></center>
	<?php else : ?>
		<div>
			<select class="form-group col-md-12" name="removeEdzes" id="removeEdzes">
				<?php foreach($s_edzesek as $s_e) : ?>
					<option value="<?=$s_e['nev']; ?>"><?=$s_e['nev']; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	<center><button type="submit" class="btn btn-primary" name="removeEdzesFajta">Eltávolítás</button></center>
	<?php endif; ?>
	
</form>