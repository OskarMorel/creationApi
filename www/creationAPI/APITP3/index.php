<?php 
    require_once("json.php");
	require_once("donnees.php");

    $request_method = $_SERVER["REQUEST_METHOD"]; // POST / GET / PUT / DELETE

    switch($_SERVER["REQUEST_METHOD"]) {
		case "GET" :
			if (!empty($_GET['demande'])) {
				// $encode=urlencode($_GET['demande']);
				// $decode=urldecode($encode);

				// décomposition URL par les / et  FILTER_SANITIZE_URL-> Supprime les caractères illégaux des URL
				$url = explode("/", filter_var($_GET['demande'],FILTER_SANITIZE_URL));
				
				switch($url[0]) {
					case 'articlesStockPrix' :
						// Retourne les articles avec le stock et les prix
						getArticleStockPrix();
                        
					break;
				
					default : 
						$infos['Statut']="KO";
						$infos['message']=$url[0]." inexistant";
						sendJSON($infos, 404) ;
				}
			} else {
				$infos['Statut']="KO";
				$infos['message']="URL non valide";
				sendJSON($infos, 404) ;
			}
			break ;
		case "PUT" :
			if (!empty($_GET['demande'])) {
				// Modification d'un client / type de client
				// Récupération des données envoyées
				$url = explode("/", filter_var($_GET['demande'],FILTER_SANITIZE_URL));
				switch($url[0]) {
					case 'CB_modifPrixStock' : 
						// Modification d'un client
						if (!empty($url[1])) {  // Attention si valeur 0 = false ->  vrai
							authentification(); // Test si on est bien authenfifié pour l'API
							$donnees = json_decode(file_get_contents("php://input"),true);
							modificationClient($donnees,$url[1] );
						} else {
							$infos['Statut']="KO";
							$infos['message']="Vous n'avez pas renseigné le No de client.";
							sendJSON($infos, 400) ;
						}		
						break ;
			} else {
				$infos['Statut']="KO";
				$infos['message']="URL non valide";
				sendJSON($infos, 404) ;
			}
	}
?>