
 $(function() {

	// Ici, le DOM est entièrement défini
	
	// -------------------   Exo 1 -------------------------------------
	// 1-2 Affichage dans la console du contenu de la balise avec id texteJQ
	console.log($('#texteJQ').html()) ; 
	
	// 1-1 Remplacement du contenu HTML de la balise avec id texteJQ
	$('#texteJQ').html('Hello world. Ce texte est affiché par jQuery.');
		
	
	// 1-2 Affichage dans la console du contenu de la balise avec id texteJQ
	console.log($('#texteJQ').html()) ;  // Affichage dans la console du contenu de la balise avec id texteJQ apres modification 

	// 1-3 Affichage du nombre de h1 contenus dans le document. 
	console.log($('h1').length + ' h1 contenu(s) dans le document');
	
	console.log($('a').css('color')); 
	
	// 1-4 Changement de couleur des col-xs-6 <a>
	$('.col-xs-6').css('color', 'yellow'); 
	$('.col-xs-12').css('color', 'blue');











	
	$('#texteJQ').mouseover(function(){
      $('#texteJQ').text('Je suis dessus' );
    });
	
 	$('#texteJQ').mouseout(function(){
      $('#texteJQ').text('Je suis sorti' );
    });
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
	// 2-1 Changement de couleur du mot contact
 	$('#Contact').mouseover(function(){
      $('#Contact').css('color', 'yellow');
    });
	$('#Contact').mouseout(function(){
      $('#Contact').css('color', 'black');
    });
	
	// 2-1 Changement de couleur du mot contact
 	$('#Adresse').mouseover(function(){
      $('#Adresse').css('color', 'yellow');
    });
	$('#Adresse').mouseout(function(){
      $('#Adresse').css('color', 'black');
    });
	
	// 2-2 - changement des images d'entete
	$('#ImageGauche').mouseover(function(){
      $('#ImageGauche').attr('src','img/Entete-LP.jpg');
	  $('#ImageDroite').attr('src','img/Entete-Capitole.jpg');
	  
    });
	$('#ImageDroite').mouseover(function(){
      $('#ImageGauche').attr('src','img/Entete-LP.jpg');
	  $('#ImageDroite').attr('src','img/Entete-Capitole.jpg');
    });
	$('#ImageGauche').mouseout(function(){
      $('#ImageGauche').attr('src','img/Entete-Capitole.jpg');
	  $('#ImageDroite').attr('src','img/Entete-LP.jpg');
    });
	$('#ImageDroite').mouseout(function(){
      $('#ImageGauche').attr('src','img/Entete-Capitole.jpg');
	  $('#ImageDroite').attr('src','img/Entete-LP.jpg');
    });
  
	// 2-3 apparition des images en 2 secondes
	$('#ImageDroite').hide();
	$('#ImageGauche').hide();
	$('#ImageDroite').show(2000);
	$('#ImageGauche').show(2000);
  
	// 2-4 Affichage de la page en 3 secondes.
	$('#central').slideDown();
  
  });
 
 
