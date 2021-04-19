<?php if(IsBerletValid($_SESSION['berletid']) && isUserLoggedIn()) : ?>
	<?php 
		//Bérlet adat frissítés
		$berletId = $_SESSION['berletid'];
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
		$query = "SELECT last_alkalom FROM users WHERE id = :id";
		$params = [':id' => $_SESSION['uid']];
		$result = getRecord($query,$params)['last_alkalom'];
		// Ha voltam bent
		if($result < $array[6] || $array[6] == 1){
			//Utolsó alkalom+dátum csere
			$query = "UPDATE users SET last_alkalom = :last_alkalom, utolso_nap = :utolso_nap WHERE id = :id";
			$params = [':last_alkalom' => $array[6], ':utolso_nap' => (string)date("Y-m-d"), ':id' => $_SESSION['uid']];
			executeDML($query,$params);
			//Edzésindex++
			$query = "SELECT start FROM tervek WHERE userid = :userid";
			$params = [':userid' => $_SESSION['uid']];
			$result = getRecord($query, $params)['start'];
			$result++;
			//Ha pihenők következnek
			while(getTerv($_SESSION['uid'],false,$result)[0] == 'Pihenő'){
				$result++;
				if($result > $_SESSION['felosztas']) {
					$result = 1;
				}
			}
			if($result > $_SESSION['felosztas']) {
					$result = 1;
			}
			$query = "UPDATE tervek SET start = :start WHERE userid = :userid";
			$params = ['start' => $result, 'userid' => $_SESSION['uid']];
			executeDML($query,$params);
		}
	 ?>
<?php endif; ?>