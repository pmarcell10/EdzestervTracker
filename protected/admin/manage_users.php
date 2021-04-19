<?php if (!IsUserAdmin()) : ?>
	No Permission.
<?php else : ?>
	<?php 
		$query = "SELECT id, fname, lname, email, permission FROM users";
		require_once DATABASE_CONTROLLER;
		$userlist = getList($query);
	?>

	<?php if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editValue'])) : ?>
		<?php 
			$edit_query = "UPDATE users SET fname = :fname, lname = :lname, email = :email, permission = :permission WHERE id = :id";
			$edit_params = [
				':fname' => $_POST['fname'],
				':lname' => $_POST['lname'],
				':email' => $_POST['email'],
				':permission' => $_POST['permission'],
				':id' => $_GET['edit']
			];
			if(!executeDML($edit_query, $edit_params)){
				header('Location: index.php');
			}
			header('Location: index.php?P=admin&A=manage_users');
		 ?>
	<?php endif; ?>

	<?php if(isset($_GET['remove'])) : ?>
		<?php 
			$remove_query = "DELETE FROM users WHERE id = :del_id";
			$remove_params = [':del_id' => $_GET['remove']];
			if(!executeDML($remove_query, $remove_params)){
				header('Location: index.php');
			}
			header('Location: index.php?P=admin&A=manage_users');
		 ?>
	<?php endif; ?>

	<?php if(isset($_GET['edit'])) : ?>
		<?php 
			$uid = $_GET['edit'];
			$user_query = "SELECT fname, lname, email, permission FROM users WHERE id = $uid";
			$result = getRecord($user_query);
		 ?>
	<center><h4>Edit User</h4></center>
	<form method="POST" style="margin-top: 16px">
		<input type="text" name="fname" id="fname" value="<?=$result['fname'] ?>">
		<input type="text" name="lname" id="lname" value="<?=$result['lname'] ?>">
		<input type="text" name="email" id="email" value="<?=$result['email'] ?>">
		<input type="text" name="permission" id="permission" value="<?=$result['permission'] ?>">
		<button type="submit" class="btn btn-primary btncenter" name="editValue">Edit User</button>
	</form>

	<?php else : ?>

		<table style="margin-top: 24px">
					<tr>
						<th scope="col">ID</th>
						<th scope="col">First Name</th>
						<th scope="col">Last Name</th>
						<th scope="col">Email</th>
						<th scope="col">Permission level</th>
						<th scope="col">Szerkesztés</th>
						<th scope="col">Törlés</th>
					</tr>
					<?php foreach ($userlist as $u) : ?>
						<tr>
							<td class="td-id"><?=$u['id']?></td>
							<td class="td-fname"><?=$u['fname']?></td>
							<td class="td-lname"><?=$u['lname']?></td>
							<td class="td-email"><?=$u['email']?></td>
							<td class="td-pl">
								<?php if($u['permission'] == 0) : ?>
									User
								<?php elseif($u['permission'] == 1) : ?>
									Seller
								<?php else : ?>
									Admin
								<?php endif; ?>
							</td>
							<td class="td-e"><a href="index.php?P=admin&A=manage_users&edit=<?=$u['id']?>">Edit</a></td>
							<td class="td-d"><a href="index.php?P=admin&A=manage_users&remove=<?=$u['id']?>" onclick="return confirm('Are you sure you want to delete?')">Remove</a></td>
						</tr>
					<?php endforeach; ?>
			</table>
		<?php endif; ?>
<?php endif; ?>