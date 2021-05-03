<?php if (!IsUserAdmin()) : //if user is not admin then deny ?>
	No Permission.
<?php else : ?>
	<?php //SQL Query for orders
		$query = "SELECT id, userid, itemid FROM orders";
		require_once DATABASE_CONTROLLER;
		$orderlist = getList($query); //array of orders
	?>

	<?php if($_SERVER['REQUEST_METHOD'] == 'POST') { //if POST request sent of:
			if(isset($_POST['deleteOrder'])){ // - delete an item
				$delquery = "DELETE FROM orders WHERE id = :id"; //SQL Query for deleting an item
				$delparams = [':id' => $_GET['edit']]; //get ID from GET tag*
				executeDML($delquery, $delparams); //no array - delete is DML
				header('Location: index.php?P=admin&A=manage_orders'); //redirect 
			}
			elseif (isset($_POST['completeOrder'])){ // - complete an order
				$query = "SELECT itemid, userid FROM orders WHERE id = :id "; //SQL Query for receiving order with the ID in GET tag
				$params = [ ':id' => $_GET['edit'] ]; //get ID from GET tag*
				$result = getRecord($query, $params); //single record variable for completed order id
				$completequery = "INSERT INTO completed_orders (itemid, userid) VALUES (:itemid, :userid)"; //SQL Query for completing order
				$completeparams = [':itemid' => $result['itemid'],
								   ':userid' => $result['userid']
				];
				if(!executeDML($completequery, $completeparams)){ //executeDML function returns false if fails to complete
					echo "Failed.";
				}
				else{ //if success - redirect back
					header('Location: index.php?P=admin&A=manage_orders');
				}
				//delete order from orders after completion
				$delquery = "DELETE FROM orders WHERE id = :id";
				$delparams = [':id' => $_GET['edit']];
				executeDML($delquery, $delparams);
				header('Location: index.php?P=admin&A=manage_orders');
			}
		}
	?>

	<?php if(isset($_GET['edit'])) : //if order edit is active?> 
		<form method="POST" onsubmit="return confirm('Are you sure?');">
			<button type="submit" class="btn btn-primary btncenter" name="deleteOrder">Delete Order</button>
		</form>
		<form method="POST" onsubmit="return confirm('Are you sure?');">
			<button type="submit" class="btn btn-primary btncenter" name="completeOrder">Mark as Complete</button>
		</form>
	<?php else : //table list of orders?>

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
							<td class="td-email"><a href="index.php?P=admin&A=manage_orders&edit=<?=$o['id']?>">Edit</a></td> <!--*SEND ID AS EDIT TAG-->
						</tr>
					<?php endforeach; ?>
			</table>
	<?php endif; ?>
<?php endif; ?>