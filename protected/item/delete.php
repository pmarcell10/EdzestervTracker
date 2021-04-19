<?php 
	$query = "SELECT userid FROM items WHERE id = :id";
	if(isset($_GET['del_id'])){
		$params = [':id' => $_GET['del_id']];
	}


	require_once DATABASE_CONTROLLER;

	$record = getRecord($query, $params);
?>

<?php if(empty($record) || $record['userid'] != $_SESSION['uid'] && !IsUserAdmin()) : ?>
	<p>No permission.</p>
<?php else : ?>
	<?php 
		$del_query = "DELETE FROM items WHERE id = :del_id";
		$del_params = [':del_id' => $_GET['del_id']];
		if(!executeDML($del_query, $del_params)){
			echo "Sikertelen törlés.";
		}
		header('Location: index.php?P=browse');
	?>
<?php endif; ?>