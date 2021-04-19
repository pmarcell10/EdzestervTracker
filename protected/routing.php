<?php 
if(!array_key_exists('P', $_GET) || empty($_GET['P']))
	$_GET['P'] = 'home';

switch ($_GET['P']) {
	case 'home': require_once PROTECTED_DIR.'normal/home.php'; break;

	case 'browse': require_once PROTECTED_DIR.'normal/browse.php'; break;

	case 'add_item': IsUserLoggedIn() ? require_once PROTECTED_DIR.'item/add.php' : header('Location: index.php'); break;

	case 'edit': IsUserLoggedIn() ? require_once PROTECTED_DIR.'edzesek/edit.php' : header('Location: index.php'); break;

	case 'login': !IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/login.php' : header('Location: index.php'); break;

	case 'register': !IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/register.php' : header('Location: index.php'); break;

	case 'logout': IsUserLoggedIn() ? UserLogout() : header('Location: index.php'); break;

	case 'users': IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/user_list.php' : header('Location: index.php'); break;

	case 'admin': IsUserAdmin() ? require_once PROTECTED_DIR.'admin/admin.php' : header('Location: index.php'); break;

	case 'delete' : IsUserLoggedIn() ? require_once PROTECTED_DIR.'item/delete.php' : header('Location: index.php'); break;

	case 'add_terv' : IsUserLoggedIn() ? require_once PROTECTED_DIR.'edzesek/add.php' : header('Location: index.php'); break;

	case 'settings' : IsUserLoggedIn() ? require_once PROTECTED_DIR.'user/settings.php' : header('Location: index.php'); break;

	case 'edzesfajta' : IsUserLoggedIn() ? require_once PROTECTED_DIR.'edzesek/addedzes.php' : header('Location: index.php'); break;

	default: require_once PROTECTED_DIR.'normal/404.php'; break;
}

?>