$(document).ready(function() {
				    // Lorsque je soumets le formulaire
				    //ajout user
				    $('.popup').on('submit', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				         var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				       
				       var id=$this.attr('alt');
				        // Je récupère les valeurs
				      	var hour =$('.hour'+id).val();
				        var acl = $('.acl'+id).val();
				        var password = $('.password'+id).val();
				        var nom = $('.nom'+id).val();
						var prenom = $('.prenom'+id).val();
						var mail = $('.mail'+id).val();
						var begin = $('.begin'+id).val();
				
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
						if(id==''){
							if(hour=== '' || acl === '' || password === '' || nom === '' || prenom === '' || mail === '' ||begin==='') {
				            alert('Les champs doivent êtres remplis');
					        } else {
					        ;
					            // Envoi de la requête HTTP en mode asynchrone
					            $.ajax({
					                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
					                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
					                data: 'action=adduser&nom='+nom+'&prenom='+prenom+'&password='+password+'&mail='+mail+'&acl='+acl+'&hour='+hour+'&begin='+begin, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
					                success: function(html) {
					                  // Je récupère la réponse du fichier PHP
					                  if(html==1)
					                  {
					                  window.location.href="admin.php?action=user";
					                  }
					                  else {
									  		  var id=$this.attr('alt');
					                          $("#retour"+id ).html( html ); // J'affiche cette réponse
					                        }
					                }
					            });
					        }
						}else{
						if(hour=== '' || acl === '' || nom === '' || id=='' || prenom === '' || mail === '') {
				            alert('Les champs doivent êtres remplis');
					        } else {
					        ;
					            // Envoi de la requête HTTP en mode asynchrone
					            $.ajax({
					                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
					                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
					                data: 'action=updateuser&nom='+nom+'&prenom='+prenom+'&password='+password+'&mail='+mail+'&acl='+acl+'&hour='+hour+"&id="+id+'&begin='+begin, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
					                success: function(html) {
					                  // Je récupère la réponse du fichier PHP
					                  if(html==1)
					                  {
					                  window.location.href="admin.php?action=user";

					                  }
					                  else {
									  		  var id=$this.attr('alt');
					                          $("#retour"+id ).html( html ); // J'affiche cette réponse
					                        }
					                }
					            });
					        }
						}
				        
				    });
					 $('.deluser').on('click', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				       	var id=$this.attr('alt');
				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(id=='') {
				            alert('Les champs doivent êtres remplis');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=deluser&id='+id, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                  if(html==1)
				                  {
				                  window.location.href="admin.php?action=user";
				                  }
				                  else {
								  		  var id=$this.attr('alt');
				                          $("#retour"+id ).html( html ); // J'affiche cette réponse
				                        }
				                }
				            });
				        }
				    });
	//gestion des categorie
					 $('.delcat').on('click', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				       	var id=$this.attr('alt');
				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(id=='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=delcat&id='+id, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour"+id ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				    });
					 $('#subnewcat').on('click', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				       	var cat=$("#newcat").val();
						var catdom=$("#catdom").val();
				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(cat==''||catdom=='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=addcat&cat='+cat+'&catdom='+catdom, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour" ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				    });
					
					
					 $('.renamecat').on('click', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
						var id=$this.attr('alt');
						var content=$("#catname"+id ).text();
						var alldom=$('#catdom').html();
						var cir=$('#cir'+id).html();
						if(cir=="oui") var chk="checked";
						else var chk ="";
						
						  $("#catname"+id ).html( '<input type="text" id="cat'+id+'" value="'+content+'"/><select id="catdom'+id+'">'+alldom+'</select><br>Eligible au CIR <input type="checkbox" '+chk+' id="cir'+id+'"/><br><button onclick="vrcat('+id+');" alt="'+id+'" class="vrcat btn btn-primary">valider</button>' );
					 });
	//gestion des domaine
					$('.deldom').on('click', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				       	var id=$this.attr('alt');
				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(id=='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=deldom&id='+id, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour"+id ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				    });
				    $('#generate').on('click', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				      	var begindate=$('#begindate').val();
						var enddate=$('#enddate').val();
						var catdom=$('#catdom').val();
					
				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(enddate=='' ||begindate=='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/admin-catchart.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'catdom='+catdom+'&begindate='+begindate+'&enddate='+enddate, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour").html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				    });
				       $('#userview').on('click', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				      	var begindate=$('#begindate').val();
						var enddate=$('#enddate').val();
						var chooseuser=$('#chooseuser').val();

				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(enddate=='' ||begindate=='' || chooseuser=='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/admin-genuserview.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'user='+chooseuser+'&begindate='+begindate+'&enddate='+enddate, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour").html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				    });
				    
					 $('#subnewdom').on('click', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				       	var dom=$("#newdom").val();
				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(dom=='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=adddom&dom='+dom, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour" ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				    });
					 $('.delcontrat').on('click', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				       	var id=$this.attr('id');
				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(id=='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=delcontrat&id='+id, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour" ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				    });
					 $('.updatecontrat').on('submit', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				        var id=$this.attr('alt');
				       	var nom=$(".nom"+id).val();
				       	var pourcent=$(".pourcentage"+id).val();
				       	var conge=$(".conge"+id).val();

				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(id==''||nom==''||pourcent==''||conge=='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=updatecontrat&id='+id+'&nom='+nom+'&pourcent='+pourcent+'&conge='+conge, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour"+id ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				    });
					  $('#addcontrat').on('submit', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				        var id=$this.attr('alt');
				       	var nom=$(".nom"+id).val();
				       	var pourcent=$(".pourcentage"+id).val();
				       	var conge=$(".conge"+id).val();

				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(id==''||nom==''||pourcent==''||conge=='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=addcontrat&nom='+nom+'&pourcent='+pourcent+'&conge='+conge, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour"+id ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				    });
					$('.modifmotif').on('submit', function(e){
						e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				        var id =$this.attr('id');
				        var type=$('#type'+id).val();
				        var nom=$('#nom'+id).val();
				         if(id===''||type===''||nom==='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=modifmotif&nom='+nom+'&type='+type+'&id='+id, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour"+id ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }

					});
					$('.addmotif').on('submit', function(e){
						e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				        var id =$this.attr('id');
				        var type=$('#type').val();
				        var nom=$('#nom').val();
				         if(type===''||nom==='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=addmotif&nom='+nom+'&type='+type, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retouradd" ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }

					});
					$('.admconge').on('click', function(e){
						e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				        var id =$this.attr('alt');
				        if($this.val()=="accepter")
				        	var state='1';
				       	if($this.val()=="refuser")
				        	var state='10';
				        
				         if(state===''||id==='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=admconge&id='+id+'&state='+state, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour" ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }

					});
					
					$('#creditconge').on('click', function(e){
						if (confirm("Attention cela ecrasera les congé des utilisateur si il en reste désirez vous continuer?")) {
							$.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=credit_conge', // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour" ).html( html ); // J'affiche cette réponse
				               }         
				                
				            });
						}

					});
						$('#okchangetime').on('click', function(e){
							var date = $('#changetime').val();
							var user= $ ('#user').val();

							$.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=transfere&date='+date+'&id='+user, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#transfretour" ).html( html ); // J'affiche cette réponse
				               }         
				                
				            });
						

					});
				$('.delmotif').on('click', function(e){
						e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				        var id =$this.attr('alt');
				      
				         if(id==='') {
				            alert('erreur');
				        } else {
				        ;
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=delmotif&id='+id, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour" ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }

					});
				$('#valid-proj-cir').on('click', function(e){
						e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				        var id =$("#cir-proj-select").val();
				      
				         if(id==='') {
				            alert('erreur');
				        } else {
				        
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=timeline&id='+id, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#time-line" ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }

					});
					$('#export').on('click', function(e){
						var id= $('#export').attr('alt');
						var begindate=$('#begindate').val();
						var enddate=$('#enddate').val();
						var dom=$('#'+id).val();
						if(id=='chooseuser'){

							$('#export').attr('href', 'include/exel.php?begindate='+begindate+'&enddate='+enddate+'&userid='+dom);
							}
						if(id=='choosecat'){
							$('#export').attr('href', 'include/catexel.php?begindate='+begindate+'&enddate='+enddate+'&catid='+dom);
						}
						if(id=='choosedom'){
							$('#export').attr('href', 'include/domexel.php?begindate='+begindate+'&enddate='+enddate+'&domid='+dom);
						}

					});
					 $('.renamedom').on('click', function(e) {
				        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
						var id=$this.attr('alt');
						var content=$("#domname"+id ).text();
						  $("#domname"+id ).html( '<input type="text" id="dom'+id+'" value="'+content+'"/><button onclick="vrdom('+id+');" alt="'+id+'" class="vrcat btn btn-primary">valider</button>' );
					 });
					 
				
					  

				}); //fin du document ready



//fonction js car comme l'element aparait aprait lechargement sionon il nest pas calculer
				function vrcat(id){
					
						 
						var cat=$('#cat'+id).val();
						var catdom=$('#catdom'+id).val();
						var cir=$('#cir'+id).val();
				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(cat==='' || id===''||catdom==''||cir=='') {
				            alert('erreur');
				        } else {
				        
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=renamecat&id='+id+'&nom='+cat+'&catdom='+catdom+'&cir='+cir, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour"+id ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				}
				function vrdom(id){
					
						 
						var dom=$('#dom'+id).val();
						 
				        // Je récupère les valeurs
				        // Je vérifie une première fois pour ne pas lancer la requête HTTP
				        // si je sais que mon PHP renverra une erreur
				        if(dom==='' || id==='') {
				            alert('erreur');
				        } else {
				        
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=renamedom&id='+id+'&nom='+dom, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#retour"+id ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }
				}
				function change(id){
						var dom=$('#'+id).val();
						$('#'+id).attr('alt', dom);
						
						$('#export').attr('alt', id); 
						
						
				}
				function valid_transfere(){
						
				        var _this = this;
				        var $this = $(this); // L'objet jQuery du formulaire
				        var id =$this.attr('alt');
				        var user =$('#user').val();
				        var date =$('#changetime').val();
				        var de =$('#de').val();
				        var vers =$('#vers').val();
				        var time =$('#nb_transf').val();
				        
				        
				         if(user===''||id==='' || date===''||de===''|| vers===''||time==='') {
				            alert('erreur');
				        } else {
				        
				            // Envoi de la requête HTTP en mode asynchrone
				            $.ajax({
				                url: 'include/ajax.php', // Le nom du fichier indiqué dans le formulaire
				                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
				                data: 'action=valid_transf&id='+id+'&user='+user+'&date='+date+'&vers='+vers+'+&de='+de+'&time='+time, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
				                success: function(html) {
				                  // Je récupère la réponse du fichier PHP
				                 
				                          $("#transfretour" ).html( html ); // J'affiche cette réponse
				                        
				                }
				            });
				        }

					}