<?php if(!IsUserLoggedIn() || $_SESSION['terv_set'] == 0) : ?>
	<?php if(!IsUserLoggedIn()) : ?>
		<p>Nem vagy bejelentkezve!</p>
	<?php elseif($_SESSION['terv_set'] == 0) : ?>
		<p>Még nincs hozzáadott edzésterved!</p>
	<?php endif; ?>
<?php else : ?>
	<?php if(array_key_exists('ae_success', $_GET) && $_GET['ae_success'] == 1) : ?>
		<center><p>Sikeresen hozzáadtad az edzésed!</p></center>
	<?php endif; ?>

	<?php 
		require_once DATABASE_CONTROLLER;
		$query = "SELECT start FROM tervek WHERE userid = :id";
		$params = ['id' => $_SESSION['uid']];
		$index = getRecord($query,$params)['start'];
	?>
	<a href="index.php?P=settings">&lt; Vissza</a>
	<center><p style="font-size: 140%; margin-bottom: 3px"><b>Edzésterv Módosítása</b></p></center>
	<center><p style="font-size: 70%; margin-bottom: 3px"><b>(A saját edzéseid *-al vannak jelölve)</b></p></center>
	<center><p style="font-size: 140%; margin-bottom: 0px">Felosztás: <?=$_SESSION['felosztas']; ?> napos.</p></center>
	<center><p>Jelenlegi következő edzésed: <?=$index; ?>. nap</p></center>

	<p>Ha nem szerepel egy edzésfajta, <a href="index.php?P=edzesfajta&ref=edit">itt</a> adhatsz hozzá, vagy törölhetsz egyet!</p>

	<?php 
		//alapedzések lekérése
		$query = "SELECT nev FROM edzesek WHERE id <> 0";
		$params = [];
		require_once DATABASE_CONTROLLER;
		$edzesek = getList($query,$params);
		//saját edzések lekérése
		$query = "SELECT nev FROM s_edzesek WHERE userid = :id";
		$params = [':id' => $_SESSION['uid']];
		$s_edzesek = getList($query,$params);
	 ?>

	 <?php 
	 	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])){
		 	$edzes_sum = "";
		 	$empty = true;
		 	$pihenok = array();
		 	for ($i=0; $i < $_SESSION['felosztas']; $i++) { 
		 		if(($_POST[$i.'_edzes1'] == '-' && $_POST[$i.'_edzes2'] == '-' && $_POST[$i.'_edzes1'] == '-') || ($_POST[$i.'_edzes1'] == 'Pihenő' || $_POST[$i.'_edzes2'] == 'Pihenő' || $_POST[$i.'_edzes3'] == 'Pihenő')){
					$edzes_sum = $edzes_sum.'Pihenő,-,-';
					array_push($pihenok, true);
				}
				else{
					$empty = false;
		 			$edzes_sum = $edzes_sum.$_POST[$i.'_edzes1'].','.$_POST[$i.'_edzes2'].','.$_POST[$i.'_edzes3'];
		 			array_push($pihenok, false);
				}
		 		$edzes_sum.= '|';
		 	}
		 	$query = "UPDATE tervek SET terv = :terv, start = :start WHERE userid = :id";
		 	$params = [':id' => $_SESSION['uid'], ':terv' => $edzes_sum, ':start' => $_POST['start']];
		 	if($pihenok[$_POST['start']-1] || $empty){
		 		if($pihenok[$_POST['start']-1]){
		 			echo "Nem választhatsz pihenőnapot következő edzésnek!";
		 		}
		 		if($empty){
		 			echo "Nem lehet üres az edzésterv!";
		 		}
		 	}
		 	else{
			 	if(!executeDML($query,$params)){
			 		echo "Sikertelen hozzáadás!";
			 	}
			 	else{
			 		header('Location: index.php?edit_success=1');
			 	}
			 }
		 }

	  ?>

	<form method="POST">
		<?php for ($i=0; $i < $_SESSION['felosztas']; $i++) : ?>
			<div class="form-group col-md-6">
				<label for="registerFelosztas"><b><?=$i+1; ?>. nap: &nbsp;</b></label>
				<select class="form-group col-md-12" style="margin-bottom: 0px" id="edzes" name="<?=$i; ?>_edzes1">
					<option value="-">-</option>
					<?php foreach($s_edzesek as $s_e ) : //saját edzések ?>
				    	<option value="<?=$s_e['nev']; ?>" <?php if(sizeof(getTerv($_SESSION['uid'],false,$i+1)) > 0 && getTerv($_SESSION['uid'],false,$i+1)[0] == $s_e['nev']) : ?> selected="selected" <?php endif; ?>>*<?=$s_e['nev']; ?></option>
				    <?php endforeach; ?>
				    <?php foreach($edzesek as $e ) : //alapedzések ?>
				    	<option value="<?=$e['nev']; ?>" <?php if(sizeof(getTerv($_SESSION['uid'],false,$i+1)) > 0 && getTerv($_SESSION['uid'],false,$i+1)[0] == $e['nev']) : ?> selected="selected" <?php endif; ?>><?=$e['nev']; ?></option>
				    <?php endforeach; ?>
				</select>
				<center>+</center>
				<select class="form-group col-md-12" style="margin-bottom: 0px" id="edzes2" name="<?=$i; ?>_edzes2">
					<option value="-">-</option>
					<?php foreach($s_edzesek as $s_e ) : //saját edzések ?>
				    	<option value="<?=$s_e['nev']; ?>" <?php if(sizeof(getTerv($_SESSION['uid'],false,$i+1)) > 1 && getTerv($_SESSION['uid'],false,$i+1)[1] == $s_e['nev']) : ?> selected="selected" <?php endif; ?>>*<?=$s_e['nev']; ?></option>
				    <?php endforeach; ?>
				    <?php foreach($edzesek as $e ) : //alapedzések ?>
				    	<option value="<?=$e['nev']; ?>" <?php if(sizeof(getTerv($_SESSION['uid'],false,$i+1)) > 1 && getTerv($_SESSION['uid'],false,$i+1)[1] == $e['nev']) : ?> selected="selected" <?php endif; ?>><?=$e['nev']; ?></option>
				    <?php endforeach; ?>
				</select>
				<center>+</center>
				<select class="form-group col-md-12" style="margin-bottom: 0px" id="edzes3" name="<?=$i; ?>_edzes3">
					<option value="-">-</option>
					<?php foreach($s_edzesek as $s_e ) : //saját edzések ?>
				    	<option value="<?=$s_e['nev']; ?>" <?php if(sizeof(getTerv($_SESSION['uid'],false,$i+1)) > 2 && getTerv($_SESSION['uid'],false,$i+1)[2] == $s_e['nev']) : ?> selected="selected" <?php endif; ?>>*<?=$s_e['nev']; ?></option>
				    <?php endforeach; ?>
				    <?php foreach($edzesek as $e ) : //alapedzések ?>
				    	<option value="<?=$e['nev']; ?>" <?php if(sizeof(getTerv($_SESSION['uid'],false,$i+1)) > 2 && getTerv($_SESSION['uid'],false,$i+1)[2] == $e['nev']) : ?> selected="selected" <?php endif; ?>><?=$e['nev']; ?></option>
				    <?php endforeach; ?>
				</select>
			</div>
		<?php endfor; ?>
		<hr>
		<div class="form-group col-md-6">
			<label for="start"><b>Add meg, hogy melyik lesz a következő edzésed (alapértelmezésben folytatódik):</b></label>
			<select class="form-group col-md-12" style="margin-bottom: 16px" id="start" name="start">
			<?php for ($i=0; $i < $_SESSION['felosztas']; $i++) : ?>
				<option value="<?=$i+1; ?>" <?php if($i+1 == $index) : ?> selected="selected" <?php endif; ?>><?=$i+1; ?>. nap</option>
			<?php endfor; ?>
			</select>
		</div>
		<center><button type="submit" style="margin-bottom: 16px;" class="btn btn-primary" name="add">Terv módosítása</button></center>
	</form>
<?php endif; ?>