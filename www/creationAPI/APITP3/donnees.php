<?php 
    function getPDO(){
		// Retourne un objet connexion à la BD
		$host='localhost';	// Serveur de BD
		$db='mezabi3';		// Nom de la BD
		$user='root';		// User 
		$pass='root';		// Mot de passe
		$charset='utf8mb4';	// charset utilisé
		
		// Constitution variable DSN
		$dsn="mysql:host=$host;dbname=$db;charset=$charset";
		
		// Réglage des options
		$options=[																				 
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES=>false];
		
		try{	// Bloc try bd injoignable ou si erreur SQL
			$pdo=new PDO($dsn,$user,$pass,$options);
			return $pdo ;			
		} catch(PDOException $e){
			//Il y a eu une erreur de connexion
			$infos['Statut']="KO";
			$infos['message']="Problème connexion base de données";
			sendJSON($infos, 500) ;
			die();
		}
	}

    function getArticleStockPrix() {
        // Retourne la liste des articles avec le stock et les prix
		try {
			$pdo=getPDO();
			$maRequete='SELECT ar.CATEGORIE, ca.DESIGNATION AS CATEGORIE, ar.CODE_ARTICLE, ar.DESIGNATION, ta.CODE_TAILLE, ta.DESIGNATION as TAILLE, co.CODE_COULEUR, co.DESIGNATION as COULEUR, sp.CODE_BARRE, sp.PRIX, sp.STOCK  
            FROM stockprix sp left join articles ar on sp.ARTICLE=ar.ID_ARTICLE 
            LEFT JOIN a_couleurs co ON sp.COULEUR = co.CODE_COULEUR 
            LEFT JOIN a_tailles ta ON sp.TAILLE = ta.CODE_TAILLE
            LEFT JOIN a_categories ca ON ar.CATEGORIE = ca.CODE_CATEGORIE
            order by ar.CATEGORIE, ar.CODE_ARTICLE, ta.CODE_TAILLE, co.DESIGNATION' ; 
			
			$stmt = $pdo->prepare($maRequete);										// Préparation de la requête
			$stmt->execute();	
				
			$clients=$stmt ->fetchALL();
			$stmt->closeCursor();
			$stmt=null;
			$pdo=null;

			sendJSON($clients, 200) ;
		} catch(PDOException $e){
			$infos['Statut']="KO";
			$infos['message']=$e->getMessage();
			sendJSON($infos, 500) ;
		}
    }

	function CB_modifPrixStock($donneesJson, $codeBarre) {
		if(!empty($donneesJson['CODE_BARRE']) 
			&& !empty($donneesJson['PRIX'])
			&& !empty($donneesJson['STOCK'])
			
		  ){
			  // Données remplies, on modifie le client
			try {
				$pdo=getPDO();
				$maRequete='UPDATE stockprix SET PRIX=:PRIX, STOCK=:STOCK WHERE CODE_BARRE = :CODE_BARRE';
				$stmt = $pdo->prepare($maRequete);						// Préparation de la requête
				$stmt->bindParam("CODE_BARRE", $codeBarre);
				$stmt->bindParam("PRIX", $donneesJson['PRIX']);				
				$stmt->bindParam("STOCK", $donneesJson['STOCK']);
				$stmt->execute();	
				$nb = $stmt->rowCount(); // nbre d'items modifiés
				
				$stmt=null;
				$pdo=null;
				
				// Retour des informations au client (statut)
				if ($nb==0) {
					// Erreur lors du update
					$infos['Statut']="KO";
					$infos['Message']="Erreur dans la mise à jour";
					sendJSON($infos, 404) ;
				} else {
					// Modification réalisée
					$infos['Statut']="OK";
					$infos['Message']="Modification effectuée";
					sendJSON($infos, 201) ;
				}

				sendJSON($infos, 201) ;
			} catch(PDOException $e){
				// Retour des informations au client 
				$infos['Statut']="KO";
				$infos['message']=$e->getMessage();
				sendJSON($infos, 500) ;
			}
		}else {
			// Données manquantes, Retour des informations au client 
			$infos['Statut']="KO";
			$infos['message']="Données incomplètes";
			sendJSON($infos, 400) ;
		}
	}




?>