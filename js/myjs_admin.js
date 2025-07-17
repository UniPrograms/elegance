// Evidenzia la voce del menu corrente
document.addEventListener('DOMContentLoaded', function () {
  
  // Ottieni il nome della pagina senza estensione
  var pageName = window.location.pathname.split("/").pop().split(".")[0];

  // Seleziona tutte le voci della sidebar
  var menuItems = document.querySelectorAll('aside.sidebar li[name-field]');

  menuItems.forEach(function (item) {
    var fieldName = item.getAttribute('name-field');

    if (fieldName.endsWith(pageName)) {
      item.classList.add('active');
    } else {
      item.classList.remove('active'); // opzionale: pulisce le altre
    }
  });
});


// Controllo delete eliminazione utente
document.addEventListener('DOMContentLoaded', function(){
  
  // Selettore per tutti i bottoni "Sposta nel carrello" dalla wishlist
  document.querySelectorAll('.admin-delete-user').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var userId = this.getAttribute("value");
      var row = this.closest("tr");
      $.ajax({
        type: "POST",
        url: "user_operation.php",
        data: {
          user_id: userId,
          operation: "delete",
        },
        dataType: "json",
      }).done(function(response){

        if(response.status == "OK"){
          
          $(row).fadeOut(400, function() {
            $(this).remove();
          });

        }
        else{
          alert("Errore: " + response.text_message);
        }
      }).fail(function (jqXHR, textStatus, errorThrown) {
  console.error("Errore AJAX:", textStatus, errorThrown);
});

    });
  });
});