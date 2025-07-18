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


// Reindirizzamento alla pagina dei dettagli utente
document.addEventListener('DOMContentLoaded', function () {  

  document.querySelectorAll('.admin-details-user').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var userId = this.getAttribute("value");
      window.location.href = "admin_viewuser.php?user_id="+userId;
      
    });
  });
});


// Controllo delete eliminazione ordine
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.admin-delete-order').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var orderId = this.getAttribute("value");
      var row = this.closest("tr");
      $.ajax({
        type: "POST",
        url: "order_operation.php",
        data: {
          order_id: orderId,
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


// Reindirizzamento alla pagina dei dettagli dell'ordine
document.addEventListener('DOMContentLoaded', function () {  

  document.querySelectorAll('.admin-details-order').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var orderId = this.getAttribute("value");
      window.location.href = "admin_vieworder.php?order_id="+orderId;
      
    });
  });
});



// Controllo delete eliminazione prodotto
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.admin-delete-product').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var productId = this.getAttribute("value");
      var row = this.closest("tr");
      $.ajax({
        type: "POST",
        url: "product_operation.php",
        data: {
          product_id: productId,
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


// Reindirizzamento alla pagina dei dettagli del prodotto
document.addEventListener('DOMContentLoaded', function () {  

  document.querySelectorAll('.admin-details-product').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var productId = this.getAttribute("value");
      window.location.href = "admin_viewproduct.php?product_id="+productId;
      
    });
  });
});


// Aggiornamento dati utente admin
document.addEventListener('DOMContentLoaded', function(){

    const updateBtn = document.querySelector("#admin-update-user");
    
    updateBtn.addEventListener("click", function(btn){

      const userId = document.getElementById("user-id").value;
      const userName = document.getElementById("user-name").value;
      const userSurname = document.getElementById("user-surname").value;
      const userEmail = document.getElementById("user-email").value;
      const userRole = document.getElementById("user-role-input").value;
      const userPhone = document.getElementById("user-phone").value;
      const userDate = document.getElementById("user-date").value;


       $.ajax({
        type: "POST",
        url: "user_operation.php",
        data: {
          user_id: userId,
          user_name: userName,
          user_surname: userSurname,
          user_email: userEmail,
          user_role: userRole,
          user_phone_number: userPhone,
          user_registration_date: userDate,
          operation: "admin-update",
        },
        dataType: "json",
      }).done(function (response) { 

          if(response.status == "OK"){
            window.location.href = "admin_viewuser.php?user_id=" + userId;
          }else{
            alert("Errore: " + response.text_message);
          }

        }).fail(function (jqXHR, textStatus, errorThrown) {
          console.error("Errore AJAX:", textStatus, errorThrown);
      });
      
    });

});



// Aggiornamento dati ordine admin
document.addEventListener('DOMContentLoaded', function(){

    const updateBtn = document.querySelector("#admin-update-order");
    
    updateBtn.addEventListener("click", function(btn){

      const orderId = document.getElementById("order-id-input").value;
      const orderStatus = document.getElementById("order-status-input").value;
   

       $.ajax({
        type: "POST",
        url: "order_operation.php",
        data: {
          order_id: orderId,
          order_status: orderStatus,
          operation: "admin-update-state",
        },
        dataType: "json",
      }).done(function (response) { 

          if(response.status == "OK"){
            window.location.href = "admin_vieworder.php?order_id=" + orderId;
          }else{
            alert("Errore: " + response.text_message);
          }

        }).fail(function (jqXHR, textStatus, errorThrown) {
          console.error("Errore AJAX:", textStatus, errorThrown);
      });
      
    });

});



/*
// Aggiornamento dati prodotto admin
document.addEventListener('DOMContentLoaded', function () {
  // Bottone custom per Carica Immagine (copertina)
  var chooseCoverBtn = document.getElementById('choose-cover-img-btn');
  var coverImgFile = document.getElementById('product-cover-img-file');
  var coverImgFilePath = document.getElementById('cover-img-file-path');
  if (chooseCoverBtn && coverImgFile && coverImgFilePath) {
    chooseCoverBtn.onclick = function() {
      coverImgFile.click();
    };
    coverImgFile.onchange = function(e) {
      if (e.target.files.length > 0) {
        coverImgFilePath.value = e.target.files[0].name;
      } else {
        coverImgFilePath.value = '';
      }
    };
  }

  // Gestione anteprima immagini multiple
  var addProductImagesBtn = document.getElementById('admin-add-product-images');
  var productImagesInput = document.getElementById('product-images-input');
  var productImagesGallery = document.getElementById('product-images-gallery');
  if (addProductImagesBtn && productImagesInput && productImagesGallery) {
    addProductImagesBtn.onclick = function() {
      productImagesInput.click();
    };
    productImagesInput.onchange = function(event) {
      var gallery = productImagesGallery;
      var currentCount = gallery.querySelectorAll('img').length;
      var files = Array.from(event.target.files);
      if (currentCount >= 6) {
        alert('Puoi caricare al massimo 6 immagini.');
        event.target.value = '';
        return;
      }
      var filesToAdd = files.slice(0, 6 - currentCount);
      filesToAdd.forEach(function(file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          var wrapper = document.createElement('div');
          wrapper.className = 'product-gallery-thumb-wrapper';
          wrapper.style.position = 'relative';
          var img = document.createElement('img');
          img.src = e.target.result;
          img.className = 'product-gallery-thumb';
          // Bottone elimina
          var delBtn = document.createElement('button');
          delBtn.type = 'button';
          delBtn.className = 'delete-thumb-btn';
          delBtn.innerHTML = '&times;';
          delBtn.title = 'Elimina immagine';
          delBtn.onclick = function() {
            wrapper.remove();
          };
          wrapper.appendChild(img);
          wrapper.appendChild(delBtn);
          gallery.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
      });
      if (files.length > filesToAdd.length) {
        alert('Puoi caricare al massimo 6 immagini.');
      }
      event.target.value = '';
    };
  }
});
*/


// Reindirizzamento alla pagina per gestire gli articoli
document.addEventListener('DOMContentLoaded', function () {  
  var goToBtn = document.querySelector("#admin-go-to-article");

  goToBtn.addEventListener("click", function(btn){
    var productId = this.getAttribute("value");
    window.location.href = "admin_viewarticle.php?product_id="+productId;
  });
});



// Aggiornamento table degli ordini tramite search bar order
document.addEventListener('DOMContentLoaded', function(){

  const searchBar = document.getElementById('searchbar-order');

    searchBar.addEventListener('keydown',  function(e) {
      if (e.key === 'Enter') {
        const value = e.target.value;
        window.location.href = "admin_orders.php?filter_string="+value;
      }
    });

});




// Aggiornamento table degli utenti tramite search bar utente
document.addEventListener('DOMContentLoaded', function(){

  const searchBar = document.getElementById('searchbar-user');

    searchBar.addEventListener('keydown',  function(e) {
      if (e.key === 'Enter') {
        const value = e.target.value;
        window.location.href = "admin_users.php?filter_string="+value;
      }
    });

});