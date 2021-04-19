<?php if(!isset($_POST['submitBtn'])) : ?>
			<h2>Enter ID: </h2>
			<form method="post">
				<input class="center-block" type="text" name="ID"><br>
				<input class="center-block" type="submit" name="submitBtn">
			</form>
		<?php else : ?>
			<?php 
				$id = $_POST['ID'];
				$array = getTds(getCode("https://secure.myoptime.eu/fit/".$id."&"));
			?>
			<?php if(empty($array)) : ?>
				<h3>Nem található bérlet <?=$id ?> kóddal.</h3>
			<?php else : ?>
				<?php 
					$data = array($array[4],$array[5],$array[6],$array[7]);
				?>
				<h2><?=$id; ?> data:</h2>
				<p><b>Bérlet típus:</b> <?=$data[0]; ?></p>
				<p><b>Vásárlás ideje:</b> <?=$data[1]; ?></p>
				<p><b>Alkalmak (Összes/Eddigi):</b> <?=$data[2]; ?></p>
				<p><b>Érvényes:</b> <?=$data[3]; ?></p>
		<?php endif; ?>
<?php endif; ?>