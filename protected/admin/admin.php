<?php if(!isset($_SESSION['permission']) || $_SESSION['permission'] < 2) : // check for admin permission?>  
	No permission.
<?php else : ?>
	<a href="index.php?P=admin&A=manage_users">Manage Users</a>
	<span> &nbsp; | &nbsp; </span>
	<a href="index.php?P=admin&A=manage_items">Manage Items</a>
	<span> &nbsp; | &nbsp; </span>
	<a href="index.php?P=admin&A=manage_orders">Manage Orders</a>

		<?php if(!array_key_exists('A', $_GET) || empty($_GET['A'])) : // if admin sub identifier not selected?>
			<h2>Choose an option.</h2>
		<?php endif; ?>
		<br>
		<?php 
			if(isset($_GET['A']) && !empty($_GET['A'])){ //if admin sub identifier is already selected
				switch($_GET['A']){ //switch for identifiers
					case 'manage_users': include_once PROTECTED_DIR.'admin/manage_users.php'; break;
					case 'manage_items': include_once PROTECTED_DIR.'admin/manage_items.php'; break;
					case 'manage_orders': include_once PROTECTED_DIR.'admin/manage_orders.php'; break;
				}
			}
		?>
<?php endif; ?>
