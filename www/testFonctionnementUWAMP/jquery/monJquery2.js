
	
 $(function() {
	function decaleImages(){
		// imageDebut++;
		// if (imageDebut>5) {imageDebut=-1;}
		// cptImage=imageDebut ;
		// $('img').each(function(index){
			// this.src='../img/IUT' + (index+1) + '.jpg';
			// cptImage++;
		// });
		console.log("jysuis");
	}
	// Exo 2 
	var imageDebut=-1 ; // Numero de l'image en cours (0 à 5)
	var MonIntervalle=2000 ; // 2000 millisecondes donc 2 secondes //
	var monTimer=setInterval("decaleImages()", MonIntervalle);
 
  });
 
 
