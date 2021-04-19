<?php require_once 'protected/config.php'; ?>
<?php require_once USER_MANAGER; ?>
<?php 
	//Felhasználói adatok lekérése
	$query = "SELECT * FROM users";
	$params =[];
	$list = getList($query,$params);

	foreach($list as $u){
		if(IsBerletValid($u['berletid'])){
			$berletId = $u['berletid'];
			$url = "https://secure.myoptime.eu/fit/".$berletId."&";
			$array = getTds(getCode($url));

			$query = "UPDATE berlet SET tipus = :tipus, vasarlas = :vasarlas, alkalmak = :alkalmak, ervenyes = :ervenyes WHERE berletid = :berletid";
			$params = [ 
						':tipus' => $array[4], 
						':vasarlas' => $array[5],
						':alkalmak' => $array[6],
						':ervenyes' => $array[7],
						':berletid' => $berletId
					];
			require_once DATABASE_CONTROLLER;
			executeDML($query,$params);
			// Ha last_alkalom < jelenlegi alkalom: csere
			$query = "SELECT last_alkalom FROM users WHERE berletid = :berletid";
			$params = [':berletid' => $berletId];
			$result = getRecord($query,$params)['last_alkalom'];
			// Ha voltam bent
			if($result < $array[6] || $array[6] == 1){
				//Utolsó alkalom+dátum csere
				$query = "UPDATE users SET last_alkalom = :last_alkalom, utolso_nap = :utolso_nap WHERE berletid = :berletid";
				$params = [':last_alkalom' => $array[6], ':utolso_nap' => (string)date("Y-m-d"), ':berletid' => $berletId];
				executeDML($query,$params);
				//Edzésindex++
				$query = "SELECT start FROM tervek WHERE userid = :userid";
				$params = [':userid' => $u['id']];
				$result = getRecord($query, $params)['start'];
				$result++;
				if($result > $u['felosztas']) {
					$result = 1;
				}
				$query = "UPDATE tervek SET start = :start WHERE userid = :userid";
				$params = ['start' => $result, 'userid' => $u['id']];
				executeDML($query,$params);
			}
		}
	}
 ?>