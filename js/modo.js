$(document).ready(function() {
  $('.modoconge').on('click', function(e){
    e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
        var _this = this;
        var $this = $(this); // L'objet jQuery du formulaire
        var id =$this.attr('alt');
        if($this.val()=="accepter")
          var state='0';
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
                data: 'action=modoconge&id='+id+'&state='+state, // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                success: function(html) {
                  // Je récupère la réponse du fichier PHP

                          $("#retour" ).html( html ); // J'affiche cette réponse

                }
            });
        }

  });
});
