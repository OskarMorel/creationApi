
<?php
	
	
	function appelAPI($apiUrl, $apiKey, &$http_status, $typeRequete="GET", $donnees=null) {
		// Interrogation de l'API
		// $apiUrl Url d'appel de l'API
		// $http_status Retourne le statut HTTP de la requete
		// $typeRequete = GET / POST / DELETE / PUT, GET par défaut si non précisé
		// $donnees = données envoyées au format JSON en PUT ET POST, rien si GET ou DELETE
		// La fonction retourne le résultat en format JSON
		
		$curl = curl_init();									// Initialisation

		curl_setopt($curl, CURLOPT_URL, $apiUrl);				// Url de l'API à appeler
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);			// Retour dans une chaine au lieu de l'afficher
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 		// Désactive test certificat
		curl_setopt($curl, CURLOPT_FAILONERROR, true);
		
		// Parametre pour le type de requete
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $typeRequete); 
		
		// Si des données doivent être envoyées
		if (!empty($donnees)) {
			curl_setopt($curl, CURLOPT_POSTFIELDS, $donnees);
			curl_setopt($curl, CURLOPT_POST, true);
		}
		
		$httpheader []= "Content-Type:application/json";
		
		if (!empty($apiKey)) {
			// Ajout de la clé API dans l'entete si elle existe (pour tous les appels sauf login)
			$httpheader = ['APIKEYDEMONAPPLI: '.$apiKey];
		}
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
		
		// A utiliser sur le réseau des PC IUT, pas en WIFI, pas sur une autre connexion
		// Uniquement sur les URL externes (pas en utilisant une API en localhost)
		//$proxy="http://cache.iut-rodez.fr:8080";
		//curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, true);
		//curl_setopt($curl, CURLOPT_PROXY,$proxy ) ;
		///////////////////////////////////////////////////////////////////////////////
		
		$result = curl_exec($curl);								// Exécution
		$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);	// Récupération statut 
		
		curl_close($curl);										// Cloture curl

		if ($http_status=="200" or $http_status=="201" ) {		// OK, l'appel s'est bien passé
			return json_decode($result,true); 					// Retourne la collection 
		} else {
			$result=[]; 										// retourne une collection Vide
			return $result;
		}
	}

?>
	

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>TP3 API STOCK</title>

		<!-- Bootstrap CSS -->
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h1>Modification des stocks et prix des articles</h1>
					<?php 
						$apiKey = "";
						$status = "";
						$apiUrl = "http://127.0.0.1/API_Demo/API/articlesStockPrix";
						
						$articlesStockPrix = appelAPI($apiUrl, $apiKey, $status);
						//$stockPrixTri = new ArrayObject($articlesStockPrix);
						//$stockPrixTri->asort();
						echo "<h1>".$status."</h1>";

						echo "<table class='table table-striped table-bordered'>";
						
						echo "<tr><th>Categorie</th><th>Code Article</th><th>Désignation</th><th>Taille</th><th>Couleur</th><th>Code Barre</th><th>Prix</th><th>Stock</th><th>Validation</th></tr>";
						foreach ($articlesStockPrix as $asp) {
							echo "<tr><td>".$asp['CATEGORIE']."</td><td>".$asp['CODE_ARTICLE']."</td><td>".$asp['DESIGNATION']."</td><td>".$asp['TAILLE']."</td><td>".$asp['COULEUR']."</td><td>".$asp['CODE_BARRE']."</td><td>".$asp['PRIX']."</td><td>".$asp['STOCK']."</td><td></td></tr>";
						}
						
						echo "</table>";
					?>
				</div>
			</div>
		</div>
		<br><br>
	</body>
</html>