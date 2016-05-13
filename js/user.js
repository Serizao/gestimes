
$(document).ready(function(){
    $('.esbutton').click(function(){
        var clickBtnValue = $(this).attr('id');
        var url = $('#url').val();
         $.ajax({
                        url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
                        type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
                        data: 'action='+clickBtnValue+'&url='+url, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                        success: function(html) {
                          // Je récupère la réponse du fichier PHP
                        
                                  $("#retourtop" ).html( html ); // J'affiche cette réponse
                                

                        }
                    });
        var date = new Date;

		var seconds = date.getSeconds();
		var minutes = date.getMinutes();
		var hour = date.getHours();
       
    });

    $('#addconge').on("submit",(function(e){
        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
        var _this = this;
        var $this = $(this);
        var begin=$('#beginholliday').val();
        var end=$('#endholliday').val();
        var jend=$('input[name="eh"]:checked').val();
        var jbegin=$('input[name="bh"]:checked').val();
        var type=$('#typeconge').val();
          if(begin === '' || end === ''||jend==''||jbegin === '' || type === '') {
            alert('Les champs doivent êtres remplis');
        } else {
             $.ajax({
                        url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
                        type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
                        data: 'action=addconge&begin='+begin+'&end='+end+'&jend='+jend+'&jbegin='+jbegin+'&type='+type, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                        success: function(html) {
                          // Je récupère la réponse du fichier PHP
                        
                                  $("#congestate" ).html( html ); // J'affiche cette réponse
                                

                        }
                    });
            }
    }));
        $('#changetimeuser').on('change', function(e){
                            var date = $('#changetimeuser').val();
                         

                            $.ajax({
                                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
                                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
                                data: 'action=transferehuser&date='+date, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                                success: function(html) {
                                  // Je récupère la réponse du fichier PHP
                                 
                                          $("#transfretour" ).html( html ); // J'affiche cette réponse
                               }         
                                
                            });
                        

                    });
    $('.delconge').on("click",(function(e){
        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
        var _this = this;
        var $this = $(this);
        var id = $this.attr('alt')
          if(id=='') {
            alert('Les champs doivent êtres remplis');
        } else {
             $.ajax({
                        url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
                        type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
                        data: 'action=delconge&id='+id, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                        success: function(html) {
                          // Je récupère la réponse du fichier PHP
                        
                                  $("#congestate" ).html( html ); // J'affiche cette réponse
                                

                        }
                    });
            }
    }));
    $('.delmouv').on("click",(function(e){
        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
        var _this = this;
        var $this = $(this);
        var id = $this.attr('alt')
        var url = $('#url').val();
          if(id==''|| url=='') {
            alert('Les champs doivent êtres remplis');
        } else {
             $.ajax({
                        url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
                        type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
                        data: 'action=del_mouv&id='+id+'&url='+url, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                        success: function(html) {
                          // Je récupère la réponse du fichier PHP
                        
                                  $("#retourtop" ).html( html ); // J'affiche cette réponse
                                

                        }
                    });
            }
    }));
    // Lorsque je soumets le formulaire
    $('.popup').on('submit', function(e) {
        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
         var _this = this;
        var $this = $(this); // L'objet jQuery du formulaire
        var id=$this.attr('alt');
      
        // Je récupère les valeurs
       
        var time = $('.time'+id).val();
        var sens = $('.sens'+id).val();
        var date = $('.date'+id).val();
        var url = $('#url').val();
        
        // Je vérifie une première fois pour ne pas lancer la requête HTTP
        // si je sais que mon PHP renverra une erreur
        if(time === '' || sens === ''||url=='') {
            alert('Les champs doivent êtres remplis');
        } else {
        ;
            // Envoi de la requête HTTP en mode asynchrone
            $.ajax({
                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
                data: 'action=edittime&sens='+sens+'&id='+id+'&date='+date+' '+time+':00&url='+url, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                success: function(html) {
                  // Je récupère la réponse du fichier PHP
                 var id=$this.attr('alt');
                          $("#retour"+id ).html( html ); // J'affiche cette réponse
                        

                }
            });
        }
    });
	$('#datecathour').on("change",(function(e){
		var date=$('#datecathour').val();
     $.ajax({
                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
                data: 'action=gethour&date='+date, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                success: function(html) {
                  // Je récupère la réponse du fichier PHP
                
                          $("#nbhour" ).html( html ); // J'affiche cette réponse
                        

                }
            });
	}));
	$('#okhour').click(function(e){
		var date=$('#datecathour').val();
		var cathour=$('#cathour').val();
		var nb=$('#timecathour').val();
        var url=$('#url').val();
		if(date === '' || nb === '' || cathour===''||url=='') {
            alert('Les champs doivent êtres remplis');
        } else {
	   		$.ajax({
	                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
	                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
	                data: 'action=categorize&date='+date+'&cathour='+cathour+'&nb='+nb+'&url='+url, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
	                success: function(html) {
	                  // Je récupère la réponse du fichier PHP
	                           
	                          $("#catretour" ).html( html ); // J'affiche cette réponse
	                        

	                }
	            });
		}
	});
}); //fin du document ready

function auto_complete_hs(date){
    $("#datecathour").val(date);
    $.ajax({
                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
                data: 'action=gethour2&date='+date, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                success: function(html) {
                  // Je récupère la réponse du fichier PHP
                         var objJSON = JSON.parse(html);
                        $("#timecathour" ).val(objJSON.hs); // J'affiche cette réponse
                }
    });
}
function valid_transfere_user(){
                        
                        var _this = this;
                        var $this = $(this); // L'objet jQuery du formulaire
                        var id =$this.attr('alt');
                        var date =$('#changetimeuser').val();
                        var de =$('#de').val();
                        var vers =$('#vers').val();
                        var time =$('#nb_transf').val();
                        
                        
                         if(id==='' || date===''||de===''|| vers===''||time==='') {
                            alert('erreur');
                        } else {
                        
                            // Envoi de la requête HTTP en mode asynchrone
                            $.ajax({
                                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
                                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
                                data: 'action=valid_transf_user&id='+id+'&date='+date+'&vers='+vers+'+&de='+de+'&time='+time, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                                success: function(html) {
                                  // Je récupère la réponse du fichier PHP
                                 
                                          $("#transfretour" ).html( html ); // J'affiche cette réponse
                                        
                                }
                            });
                        }

                    }