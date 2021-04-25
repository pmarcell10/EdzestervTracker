<?php 
function IsUserLoggedIn() {
	return $_SESSION  != null && array_key_exists('uid', $_SESSION) && is_numeric($_SESSION['uid']);
}

function IsUserAdmin(){
	if(IsUserLoggedIn() && isset($_SESSION['permission'])){
		return $_SESSION['permission'] == 2;
	}
}

function UserLogout() {
	session_unset();
	session_destroy();
	header('Location: index.php');
}

function UserLogin($email, $password) {
	$query = "SELECT id, fname, lname, email, berletid, felosztas, permission, terv_set, rotation FROM users WHERE email = :email AND password = :password";
	$params = [
		':email' => $email,
		':password' => sha1($password)
	]; 

	require_once DATABASE_CONTROLLER;
	$record = getRecord($query, $params);


	if(!empty($record)) {
		$_SESSION['uid'] = $record['id'];
		$_SESSION['fname'] = $record['fname'];
		$_SESSION['lname'] = $record['lname'];
		$_SESSION['email'] = $record['email'];
		$_SESSION['berletid'] = $record['berletid'];
		$_SESSION['felosztas'] = $record['felosztas'];
		$_SESSION['permission'] = $record['permission'];
		$_SESSION['terv_set'] = $record['terv_set'];
		$_SESSION['rotation'] = $record['rotation'];
		header('Location: index.php');
	}
	return false;
}

function UserRegister($email, $password, $fname, $lname, $berletId, $felosztas) {
	$query = "SELECT id FROM users email = :email";
	$params = [ ':email' => $email ];

	require_once DATABASE_CONTROLLER;
	$record = getRecord($query, $params);
	if(empty($record)) {
		$query = "INSERT INTO users (fname, lname, email, password, berletid, felosztas, last_alkalom, terv_set, rotation, permission, utolso_nap) VALUES (:first_name, :last_name, :email, :password, :berletid, :felosztas, :last_alkalom, :terv_set, :rotation, :permission, :utolso_nap)";
		$params = [
			':first_name' => $fname,
			':last_name' => $lname,
			':email' => $email,
			':password' => sha1($password),
			':berletid' => $berletId,
			':felosztas' => $felosztas,
			':last_alkalom' => 0,
			':terv_set' => 0,
			':rotation' => 0,
			':permission' => 0,
			':utolso_nap' => "Nincs megadva"
		];

		if(executeDML($query, $params)) {
			$url = "https://secure.myoptime.eu/fit/".$berletId."&";
			$array = getTds(getCode($url));
			$query_berlet = "INSERT INTO berlet (berletid, tipus, vasarlas, alkalmak, ervenyes) VALUES (:berletid, :tipus, :vasarlas, :alkalmak, :ervenyes)";
			$params_berlet = [
				':berletid' => $berletId, 
				':tipus' => $array[4], 
				':vasarlas' => $array[5],
				':alkalmak' => $array[6],
				':ervenyes' => $array[7]
			];
			executeDML($query_berlet, $params_berlet);
			header('Location: index.php?P=login&success=1');
		}
	} 
	return false;
}

?>