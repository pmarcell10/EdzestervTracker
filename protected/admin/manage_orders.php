<?php if (!IsUserAdmin()) : ?>
	No Permission.
<?php else : ?>
	<?php 
		$query = "SELECT id, userid, itemid FROM orders";
		require_once DATABASE_CONTROLLER;
		$orderlist = getList($query);
	?>

	<?php if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if(isset($_POST['deleteOrder'])){
				$delquery = "DELETE FROM orders WHERE id = :id";
				$delparams = [':id' => $_GET['edit']];
				executeDML($delquery, $delparams);
				header('Location: index.php?P=admin&A=manage_orders');
			}
			elseif (isset($_POST['completeOrder'])){
				$query = "SELECT itemid, userid FROM orders WHERE id = :id ";
				$params = [ ':id' => $_GET['edit'] ];
				$result = getRecord($query, $params);
				$completequery = "INSERT INTO completed_orders (itemid, userid) VALUES (:itemid, :userid)";
				$completeparams = [':itemid' => $result['itemid'],
								   ':userid' => $result['userid']
				];
				if(!executeDML($completequery, $completeparams)){
					echo "Failed.";
				}
				else{
					header('Location: index.php?P=admin&A=manage_orders');
				}
				##
				$delquery = "DELETE FROM orders WHERE id = :id";
				$delparams = [':id' => $_GET['edit']];
				executeDML($delquery, $delparams);
				header('Location: index.php?P=admin&A=manage_orders');
			}
		}
	?>

	<?php if(isset($_GET['edit'])) : ?>
		<form method="POST" onsubmit="return confirm('Are you sure?');">
			<button type="submit" class="btn btn-primary btncenter" name="deleteOrder">Delete Order</button>
		</form>
		<form method="POST" onsubmit="return confirm('Are you sure?');">
			<button type="submit" class="btn btn-primary btncenter" name="completeOrder">Mark as Complete</button>
		</form>
	<?php else : ?>

		<table style="margin-top: 24px">
					<tr>
						<th scope="col">Order ID</th>
						<th scope="col">Item ID</th>
						<th scope="col">User ID</th>
						<th scope="col">Edit</th>
					</tr>
					<?php foreach ($orderlist as $o) : ?>
						<tr>
							<td class="td-id"><?=$o['id']?></td>
							<td class="td-fname"><?=$o['itemid']?></td>
							<td class="td-lname"><?=$o['userid']?></td>
							<td class="td-email"><a href="index.php?P=admin&A=manage_orders&edit=<?=$o['id']?>">Edit</a></td>
						</tr>
					<?php endforeach; ?>
			</table>
	<?php endif; ?>
<?php endif; ?>