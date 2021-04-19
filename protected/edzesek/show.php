<?php if(array_key_exists('edit_success', $_GET) && $_GET['edit_success'] == 1) : ?>
	<center><p style="font-size: 100%; margin-bottom: 6px"><i>Módosítások elvégezve!</i></p></center>
<?php endif; ?>

<center><p style="font-size: 200%; margin-bottom: 16px"><b>Üdv, <?=$_SESSION['lname']; ?></b></p></center>
<center><p style="font-size: 100%; margin-bottom: 0px">Mai dátum: <?=date("Y-m-d"); ?></p></center>
<hr>
<hr>

<?php 
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['setRotation'])) {
		$query = "UPDATE users SET rotation = :rotation WHERE id = :id";
		$params = [':rotation' => $_POST['rotation'], ':id' => $_SESSION['uid']];
		require_once DATABASE_CONTROLLER;
		if(!executeDML($query,$params)){
			echo "Sikertelen beállítás.";
		}
		else {
			$_SESSION['rotation'] = $_POST['rotation'];
			Header('Location: index.php');
		}
	} 
	//Gomb alapú frissítés
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['done'])){
		require_once DATABASE_CONTROLLER;
		//Utolsó dátum beállítás
		$query = "UPDATE users SET utolso_nap = :utolso_nap WHERE id = :id";
		$params = [':utolso_nap' => (string)date("Y-m-d"), ':id' => $_SESSION['uid']];
		executeDML($query,$params);
		//Jelenlegi edzésindex lekérdezés
		$query = "SELECT start FROM tervek WHERE userid = :userid";
		$params = [':userid' => $_SESSION['uid']];
		$result = getRecord($query,$params);
		$result = $result['start'];
		// Ha pihenők következnek
		$result++;
		while(getTerv($_SESSION['uid'],false,$result)[0] == 'Pihenő'){
				$result++;
				if($result > $_SESSION['felosztas']) {
					$result = 1;
				}
			}
		if($result > $_SESSION['felosztas']) {
					$result = 1;
		}
		// Frissítés
		$query = "UPDATE tervek SET start = :start WHERE userid = :userid";
		$params = [':start' => $result, ':userid' => $_SESSION['uid']];
		if(!executeDML($query, $params)){
			echo "Sikertelen";
		}
		else {
			Header('Location: index.php');
		}
	}

?>

<?php if(array_key_exists('rotation', $_SESSION) && $_SESSION['rotation'] == 0) : ?>
	<form method="POST">
		<label for="start"><b>Állítsd be, hogy mi alapján váltson a terved:</b></label>
		<select class="form-group col-md-12" style="margin-bottom: 16px" id="rotation" name="rotation">	
			<option value="1">Automatikus (Csak érvényes Cutler azonosítóval)</option>
			<option value="2">Manuális (Én szeretném váltani, ha elvégeztem egy edzést)</option>
		</select>
		<center><button type="submit" style="margin-bottom: 16px;" class="btn btn-primary" name="setRotation">Kész</button></center>
	</form>

	<?php elseif($_SESSION['rotation'] == 1) : //Bérlet alapú váltás ?>	
		<?php include_once PROTECTED_DIR.'user/refresh_berlet.php'; ?>
		<?php if(!IsBerletValid($_SESSION['berletid'])) : ?>
			<p><center>Nem sikerült a bérlet alapú azonosítás, vagy érvénytelen bérlet azonosító, kérlek <a href="index.php?P=settings">válts</a> manuális követési módra.</center></p>
		<?php else: ?>
			<div style="border: 1px solid darkgreen; border-radius: 10px; box-shadow: 3px 3px #888888;">
				<center><h2 style="margin-bottom: 24px"><u>Következő edzés: </h2></u></center>
				<?php 
					$terv = getTerv($_SESSION['uid']);
				?>
				<?php for ($i=0; $i < count($terv); $i++) : ?>
					<h2><center><b><?=$terv[$i]; ?></b></center></h2>
					<?php if($i<count($terv)-1) : ?>
						<h2><center>+</center></h2>
					<?php endif; ?>
				<?php endfor; ?>
			</div>
			<hr>
			<hr>
			<center><img style="width: 30%; margin-bottom: 6px" src="./public/cutler.png"></center>
			<center><p style="font-size: 100%; margin-bottom: 8px"><i>Bérlet alapú váltás aktív (ID: <?=$_SESSION['berletid']; ?>)</i></p></center>
			<center><p style="font-size: 80%; margin-bottom: 6px">Utolsó edzésed dátuma: <?=getLastDate(); ?></p></center>
			<center><p style="font-size: 80%; margin-bottom: 6px"><u>Utolsó edzésed tartalma:</u>
			<?php //ELŐZŐ TERV KIÍRATÁSA
				require_once DATABASE_CONTROLLER;
				$query = "SELECT start FROM tervek WHERE userid = :userid";
				$params = [':userid' => $_SESSION['uid']];
				$result = getRecord($query,$params);
				$result = $result['start'];
				$prev_nap = $result-1;
				if($prev_nap == 0){
					$prev_nap = $_SESSION['felosztas'];
				}
				$prev_terv = getTerv($_SESSION['uid'],false,$prev_nap);
				while ($prev_terv[0] == 'Pihenő') {
					$prev_nap--;
					if($prev_nap == 0){
						$prev_nap = $_SESSION['felosztas'];
					}
					$prev_terv = getTerv($_SESSION['uid'],false,$prev_nap);
			}
			 ?>
			<?php for ($i=0; $i < count($prev_terv); $i++) : ?>
				<p style="margin-bottom: 0px"><b><?=$prev_terv[$i]; ?></b></p>
				<?php if($i<count($prev_terv)-1) : ?>
					&nbsp; + &nbsp;
				<?php endif; ?>
			<?php endfor; ?>
			</p></center>
	<?php endif; ?>
	

<?php else: //Manuális váltás ?>
	<center><h2 style="margin-bottom: 24px"><u>Következő edzés: </h2></u></center>
	<?php 
		$terv = getTerv($_SESSION['uid']);
	 ?>
	<div style="border: 1px solid darkgreen; border-radius: 10px; box-shadow: 3px 3px #888888; margin-bottom: 16px">
		<?php for ($i=0; $i < count($terv); $i++) : ?>
			<h2><center><b><?=$terv[$i]; ?></b></center></h2>
			<?php if($i<count($terv)-1) : ?>
				<h2><center>+</center></h2>
			<?php endif; ?>
		<?php endfor; ?>
	</div>
	<form method="POST">
		<center><button type="submit" style="margin-bottom: 16px;" class="btn btn-primary" name="done">Végeztem</button></center>
	</form>
	<hr>
		<hr>
		<center><img style="width: 10%; margin-bottom: 6px" src="./public/manual.gif"></center>
		<center><p style="font-size: 100%">Manuális váltás aktív</p></center>
		<center><p style="font-size: 80%">Utolsó edzésed dátuma: <?=getLastDate(); ?></p></center>
		<center><p style="font-size: 80%">Utolsó edzésed tartalma: 
		<?php //ELŐZŐ TERV KIÍRATÁSA
			require_once DATABASE_CONTROLLER;
			$query = "SELECT start FROM tervek WHERE userid = :userid";
			$params = [':userid' => $_SESSION['uid']];
			$result = getRecord($query,$params);
			$result = $result['start'];
			$prev_nap = $result-1;
			if($prev_nap == 0){
				$prev_nap = $_SESSION['felosztas'];
			}
			$prev_terv = getTerv($_SESSION['uid'],false,$prev_nap);
			while ($prev_terv[0] == 'Pihenő') {
				$prev_nap--;
				if($prev_nap == 0){
					$prev_nap = $_SESSION['felosztas'];
				}
				$prev_terv = getTerv($_SESSION['uid'],false,$prev_nap);
			}
		 ?>
		<?php for ($i=0; $i < count($prev_terv); $i++) : ?>
			<p style="margin-bottom: 0px"><b><?=$prev_terv[$i]; ?></b></p>
			<?php if($i<count($prev_terv)-1) : ?>
				&nbsp; + &nbsp;
			<?php endif; ?>
		<?php endfor; ?>
		</p></center>
<?php endif; ?>
