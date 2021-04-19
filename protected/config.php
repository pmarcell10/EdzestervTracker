<?php 
define('BASE_DIR', './');
define('PUBLIC_DIR', BASE_DIR.'public/');
define('PROTECTED_DIR', BASE_DIR.'protected/');

define('DATABASE_CONTROLLER', PROTECTED_DIR.'database.php');
define('USER_MANAGER', PROTECTED_DIR.'userManager.php');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'edzes');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');

function refreshSession(){
	$query = "SELECT id, fname, lname, email, berletid, felosztas, permission, terv_set, rotation FROM users WHERE id = :id";
	$params = [
		':id' => $_SESSION['uid']
	]; 

	require_once DATABASE_CONTROLLER;
	$record = getRecord($query, $params);

	$_SESSION['uid'] = $record['id'];
	$_SESSION['fname'] = $record['fname'];
	$_SESSION['lname'] = $record['lname'];
	$_SESSION['email'] = $record['email'];
	$_SESSION['berletid'] = $record['berletid'];
	$_SESSION['felosztas'] = $record['felosztas'];
	$_SESSION['permission'] = $record['permission'];
	$_SESSION['terv_set'] = $record['terv_set'];
	$_SESSION['rotation'] = $record['rotation'];
}

function getCode($url){
	$arrContextOptions=array(
    	"ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    	),
	);  

	$response = file_get_contents($url, false, stream_context_create($arrContextOptions));
	$code = (string)htmlentities($response);
	return $code;
}

function getTds($code, $start = "TD", $end = "/TD"){
	$array = array();
	while(strpos($code,$start) !== false){
		$s = strpos($code,$start)+7;
		$e = strpos($code,$end)-5;
		$word = '';
		for ($i=$s; $i < $e; $i++) { 
			$word .= $code{$i};
		}
		array_push($array,$word);
		$code = substr($code, -(strlen($code)-$e-19));
	}
	// Alkalom kezelés
	$alkalom = '';
	for ($i=0; $i < strlen($array[6]); $i++) { 
		if(is_numeric($array[6]{$i})){
			$alkalom .= $array[6]{$i};
		}
	}
	$array[6] = substr($alkalom,2);
	return $array;
}

function getTerv($userid, $prev = false, $terv_index = -1){
	//index-1 kezelés itt, paraméterben minimum 1 jöhet be!!!
	require_once DATABASE_CONTROLLER;
	$query = "SELECT terv, start FROM tervek WHERE userid = :userid";
	$params = [':userid' => $userid];
	$result = getRecord($query,$params);
	//
	if(!$prev && $terv_index == -1){
		$terv_index = $result['start']--;
	}
	if($terv_index != -1 && !$prev){
		$terv_index--;
	}
	if($prev){
		$terv_index = $result['start']-2;
		if($terv_index = -1){
			$terv_index = $_SESSION['felosztas']-1;
		}
	}
	$terv_array = array();
	$terv_current = '';
	$current_index = 0;
	for ($i=0; $i < strlen($result['terv']); $i++) { 
		if($result['terv']{$i} == '|' && $current_index < $terv_index){
			$result['terv'] = substr($result['terv'],$i+1);
			$current_index++;
			$i=-1;
		}
	}
	for ($i=0; $i < strlen($result['terv']); $i++) { 
		if($result['terv']{$i} != ',' &&  $result['terv']{$i} != '-' && $result['terv']{$i} != '|'){
			$terv_current .= $result['terv']{$i};
		}
		if($result['terv']{$i} == ','){
			if($terv_current != ''){
				array_push($terv_array, $terv_current);
				$terv_current = '';
			}
		}
		if($result['terv']{$i} == '|'){
			if($terv_current != ''){
				array_push($terv_array, $terv_current);
				$terv_current = '';
			}
			break;
		}
		
	}
	return $terv_array;
}

function getLastDate(){
	require_once DATABASE_CONTROLLER;
	$query = "SELECT utolso_nap FROM users WHERE id = :id";
	$params = [':id' => $_SESSION['uid']];
	$date = getRecord($query,$params);
	$date = $date['utolso_nap'];
	if((string)$date == '0'){
		return 'Nincs adat.';
	}
	else return $date;
}

function IsBerletValid($id){
	return (strlen(getCode("https://secure.myoptime.eu/fit/".$id."&")) > 1000);
}

?>
