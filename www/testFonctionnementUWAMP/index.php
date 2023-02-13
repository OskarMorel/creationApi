<!doctype html>
<html lang="fr">
	<head>
	  <meta charset="utf-8">
	  <title>Test de UWAMP</title>
	  <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	  <style>
		.cadre {
			border: 2px solid grey;
			border-radius: 6px;
			background: linear-gradient(to left, white, grey);
			line-height: 30px;
			text-align: center;
			font-size :2em; 
			margin-top:20px;
		} 
		.cadreColle{
			border: 2px solid grey;
			border-radius: 6px;
			background: linear-gradient(to left, white, grey);
			line-height: 30px;
			text-align: center;
			font-size :2em; 	
			margin-top:5px;
		}
		.vert{
			background: linear-gradient(to left, white, green);
		}
		.rouge{
			background: linear-gradient(to left, white, red);
		}
		</style>
	</head>
	<body>
		<div class="container">
			<!-- Test Bootstrap -->
			<div class="row">
				<div class="col-xs-12 cadre">
					1 - Test de fonctionnement Bootstrap<br/>
					Il doit y avoir deux cases en 6/12ème
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 cadreColle vert">
					Bootstrap case 1
				</div>
				<div class="col-xs-6 cadreColle vert">
					Bootstrap case 2
				</div>				
			</div>	

			<!-- Test PHP-->
			<div class="row">
				<div class="col-xs-12 cadre">
					2 - Test de fonctionnement PHP
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 cadreColle vert" ID="TESTPHP">
					<?php Echo "PHP fonctionne !!<br/>";?>
				</div>
			</div>
			<!-- Test MYSQL -->
			<div class="row">
				<div class="col-xs-12 cadre">
					3 - Test de fonctionnement MYSQL
				</div>
				<?php

					$PARAM_hote='localhost'; // le chemin vers le serveur
					$PARAM_port='3306';
					$PARAM_nom_bd='basetest'; // le nom de votre base de données
					$PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
					$PARAM_mot_passe='root'; // mot de passe de l'utilisateur pour se connecter

					try
					{
						$connexion = new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
						$connexion->exec('SET NAMES utf8');
					}
					 
					catch(Exception $e)
					{
						echo "<div class='col-xs-12 cadreColle rouge'>";
						echo "MYSQL ne fonctionne pas ! ";
						echo 'Erreur : '.$e->getMessage().'<br />';
						echo 'N° : '.$e->getCode();
						echo "</div>" ;
						exit();
					}


				?>			
			</div>				
				<div class="row">
					<div class="col-xs-12 cadreColle vert">
						<?php Echo "MYSQL fonctionne !!<br/>";?>
				</div>
			</div>			
		
			<div class="row">
				<div class="col-xs-12 cadre">
					4 - Test de l'extraction depuis la base<br/>
					Vous devriez obtenir : <br/>
					Utilisateur : 1 Dupont Marcel 23 <br/>
					Utilisateur : 2 Durand Pierre 21<br/>
					Utilisateur : 5 Accentués àéçïêè 42<br/>
				</div>
				<?php 
					try{
						$resultats=$connexion->query("SELECT id,nom,prenom,age FROM tabletest ORDER BY id ASC"); // on va chercher tous les membres de la table qu'on trie par ordre croissant
						$resultats->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le résultat soit récupérable sous forme d'objet
						echo '<div class="col-xs-12 cadreColle rouge" ID="ResultatSQL" >';
						echo "Résultat : <br/>";
						echo '<div id="resultatSQL">' ;
						while( $ligne = $resultats->fetch() ) // on récupère la liste des membres
						{
								echo 'Utilisateur : '.$ligne->id.' '.$ligne->nom.' '.$ligne->prenom.' '.$ligne->age.'<br />'; // on affiche les membres
						}
						$resultats->closeCursor(); // on ferme le curseur des résultats
						echo "</div></div>";
					}
					catch(Exception $e)
					{	
						echo '<div class="col-xs-12 cadreColle rouge">';
						Echo "Impossible de d'extraire depuis la BD !!<br/>";
						echo 'Erreur : '.$e->getMessage().'<br />';
						echo 'N° : '.$e->getCode();
						echo "/div>";
						exit();
					}
				?>				
			
			</div>
	
			<div class="row">
				<div class="col-xs-12 cadre">
					5 - Test de fonctionnement JQUERY
				</div>
			
				<div class="col-xs-12 cadreColle rouge" id="case1">
					JQUERY NE FONCTIONNE PAS
				</div>
			</div>		
		</div>
		

		<script src="jquery/jquery-3.3.1.js"></script>
		
		<script type ="text/Javascript">
			$(function() {
				$('#case1').html("JQUERY FONCTIONNE !");
				$('#case1').removeClass("rouge");
				$('#case1').addClass("vert");
				
				var position = $('#resultatSQL').html().indexOf("5 Accentués àéçïêè");
				if (position==-1) {
					$('#ResultatSQL').addClass("rouge");
					$('#ResultatSQL').removeClass("vert");
				} else {
					$('#ResultatSQL').addClass("vert");
					$('#ResultatSQL').removeClass("rouge");
				}
				var position = $('#TESTPHP').html().indexOf("PHP fonctionne !!");
				if (position==-1) {
					$('#TESTPHP').addClass("rouge");
					$('#TESTPHP').removeClass("vert");
				} else {
					$('#TESTPHP').addClass("vert");
					$('#TESTPHP').removeClass("rouge"); 
				}
			});
		</script>
	</body>
</html>