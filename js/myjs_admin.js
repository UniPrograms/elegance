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

    const updateBtn = document.getElementById("admin-update-user");
    
    updateBtn.addEventListener("click", function(btn){

      const userId = document.getElementById("user-id").value;
      const userName = document.getElementById("user-name").value;
      const userSurname = document.getElementById("user-surname").value;
      const userRole = document.getElementById("user-role-input").value;
      const userPhone = document.getElementById("user-phone").value;

      // Validazione numero di telefono (deve essere 0 o 10 cifre)
      if (userPhone && userPhone.trim() !== '') {
        var phoneValue = userPhone.replace(/\s/g, ''); // Rimuovi spazi
        if (phoneValue.length !== 10) {
          alert('Il numero di telefono deve essere di 10 cifre o lasciato vuoto.');
          return false;
        }
      }

       $.ajax({
        type: "POST",
        url: "user_operation.php",
        data: {
          user_id: userId,
          user_name: userName,
          user_surname: userSurname,
          user_role: userRole,
          user_phone_number: userPhone,
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
    
    if (updateBtn) {
        console.log("Bottone admin-update-order trovato");
        
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
    }

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
    window.location.href = "admin_viewarticlestable.php?product_id="+productId;
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


// Aggiornamento table dei prodotto tramite search bar prodotto
document.addEventListener('DOMContentLoaded', function(){

  const searchBar = document.getElementById('searchbar-product');

    searchBar.addEventListener('keydown',  function(e) {
      if (e.key === 'Enter') {
        const value = e.target.value;
        window.location.href = "admin_products.php?filter_string="+value;
      }
    });

});



// Aggiornamento table degli articoli tramite search bar articoli
document.addEventListener('DOMContentLoaded', function(){

  const searchBar = document.getElementById('searchbar-article');

    searchBar.addEventListener('keydown',  function(e) {
      if (e.key === 'Enter') {
        var params = new URLSearchParams(window.location.search);
        var productId = params.get("product_id");
        const value = e.target.value;
        window.location.href = "admin_viewarticlestable.php?product_id="+productId+"&filter_string="+value;
      }
    });

});



// Per andare ad aggiungere un nuovo articolo
document.addEventListener('DOMContentLoaded', function () {  
  var goToBtn = document.getElementById('admin-add-article');

  goToBtn.addEventListener("click", function(btn){
    var params = new URLSearchParams(window.location.search);
    var productId = params.get("product_id");
    window.location.href = "admin_addarticle.php?product_id="+productId;
  });
});



// Per andare a modificare un articolo già esistente
document.addEventListener('DOMContentLoaded', function () {  

  document.querySelectorAll('.admin-update-article').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var params = new URLSearchParams(window.location.search);
    var productId = params.get("product_id");
    var articleId = this.getAttribute("value");
    window.location.href = "admin_updatearticle.php?product_id="+productId+"&article_id="+articleId;
      
    });
  });
});



// Controllo delete eliminazione di un articolo
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.admin-delete-article').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var articleId = this.getAttribute("value");
      var row = this.closest("tr");
      $.ajax({
        type: "POST",
        url: "article_operation.php",
        data: {
          article_id: articleId,
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



// Controllo de tasto per tornare indietro nella schermata degli articoli
document.addEventListener('DOMContentLoaded', function () {  
    var goToBtn = document.getElementById('admin-cancel-article');

    goToBtn.addEventListener("click", function () {

      const params = new URLSearchParams(window.location.search);
      const productId = params.get("product_id");

      // Esegui redirect solo se productId è presente
      window.location.href = "admin_viewarticlestable.php?product_id=" + productId;
      
    });
});



// Controllo del tasto per inserire un nuovo articolo
document.addEventListener('DOMContentLoaded', function () {  
    var goToBtn = document.getElementById('admin-store-article');

    goToBtn.addEventListener("click", function () {

      

      const params = new URLSearchParams(window.location.search);
      const productId = params.get("product_id");
      const sizeId = document.getElementById("article-add-size").value;
      const colorId = document.getElementById("article-add-color").value;
      const quantity = document.getElementById("article-add-quantity").value;
 

        $.ajax({
          type: "POST",
          url: "article_operation.php",
          data: {
            product_id: productId,
            size_id: sizeId,
            color_id:colorId,
            qty:quantity,
            operation: "store",
          },
          dataType: "json",
        }).done(function(response){
            if(response.status == "OK"){
              window.location.href = "admin_viewarticlestable.php?product_id="+productId;
            }
            else{
              alert("Errore: " + response.text_message);
            }

        }).fail(function(){
          alert("Errore, qualcosa è andato storto");
        });
    });
});



// Controllo del tasto per aggiornare un articolo esistente
document.addEventListener('DOMContentLoaded', function () {  
    var updateBtn = document.getElementById('admin-update-article');

    if (updateBtn) {
        updateBtn.addEventListener("click", function () {
            const params = new URLSearchParams(window.location.search);
            const productId = params.get("product_id");
            
            // Prendi gli ID dagli attributi data-value
            const sizeId = document.getElementById("article-update-size").getAttribute("data-value");
            const colorId = document.getElementById("article-update-color").getAttribute("data-value");
            const quantity = document.getElementById("article-update-quantity").value;


            $.ajax({
                type: "POST",
                url: "article_operation.php",
                data: {
                    product_id: productId,
                    size_id: sizeId,
                    color_id: colorId,
                    qty: quantity,
                    operation: "store",
                },
                dataType: "json",
            }).done(function(response){
                if(response.status == "OK"){
                    window.location.href = "admin_viewarticlestable.php?product_id="+productId;
                }
                else{
                    alert("Errore: " + response.text_message);
                }
            }).fail(function(jqXHR, textStatus, errorThrown){
                console.error("Errore AJAX (update article):", {
                    status: jqXHR.status,
                    statusText: jqXHR.statusText,
                    responseText: jqXHR.responseText,
                    textStatus: textStatus,
                    errorThrown: errorThrown
                });
                alert("Errore AJAX: " + textStatus + " - " + errorThrown);
            });
        });
    }
});



// Controllo tasto per aggiornamento e inserimento di un prodotto
document.addEventListener('DOMContentLoaded', function(){

  const updateBtn = document.getElementById('admin-update-product');

  updateBtn.addEventListener("click", function(){

    const productId = document.getElementById("product-id").value;
    const productName = document.getElementById("product-name-input").value;
    const productPrice = document.getElementById("product-price").value;
    const productDescription = document.getElementById("product-description").value;
    const productBrandId = document.getElementById("product-brand-input").value;
    const productCategoryId = document.getElementById("product-category").value;
    const productSexId = document.getElementById("product-gender").value;

    if(productId.length != 0){
      data = {operation:"store", product_id:productId, product_name:productName, product_price:productPrice, product_description:productDescription, brand_id:productBrandId, category_id:productCategoryId, sex_id:productSexId}
    }else{
      data = {operation:"store", product_name:productName, product_price:productPrice, product_description:productDescription, brand_id:productBrandId, category_id:productCategoryId, sex_id:productSexId}
    }

    $.ajax({
      type: "POST",
      url: "product_operation.php",
      data: data,
      dataType: "json",
    }).done(function(response){
      if(response.status == "OK"){
        window.location.href = "admin_viewproduct.php?product_id="+response.product_id;
      }else{
        alert("Errore: " + response.text_message);
      }
    }).fail(function(jqXHR, textStatus, errorThrown){
      console.error("Errore AJAX completo:", {
        status: jqXHR.status,
        statusText: jqXHR.statusText,
        responseText: jqXHR.responseText,
        responseJSON: jqXHR.responseJSON,
        textStatus: textStatus,
        errorThrown: errorThrown,
        readyState: jqXHR.readyState,
        url: jqXHR.responseURL
      });
      alert("Errore AJAX completo:\nStatus: " + jqXHR.status + "\nStatusText: " + jqXHR.statusText + "\nResponseText: " + jqXHR.responseText + "\nTextStatus: " + textStatus + "\nErrorThrown: " + errorThrown);
    });
  });
});



// Controllo del tasto per aggiungere un nuovo prodotto
document.addEventListener('DOMContentLoaded', function(){

  const addNewProductBtn = document.getElementById('admin-add-new-product');

  addNewProductBtn.addEventListener("click", function(btn){
    window.location.href = "admin_viewproduct.php";
  });

});



// Quando viene caricata la pagina per admin_viewproduct, disabilita eventualmente il tasto per gli articoli
document.addEventListener('DOMContentLoaded', function(){
  // Controlla se siamo nella pagina admin_viewproduct.php
  if (window.location.pathname.includes('admin_viewproduct.php')) {
    const goToArticleBtn = document.getElementById('admin-go-to-article');
    
    if (goToArticleBtn) {
      // Ottieni il product_id dalla query string
      const urlParams = new URLSearchParams(window.location.search);
      const productId = urlParams.get('product_id');
      
      // Se non c'è product_id, disabilita il button
      if (!productId) {
        goToArticleBtn.disabled = true;
        goToArticleBtn.style.opacity = '0.5';
        goToArticleBtn.style.cursor = 'not-allowed';
        goToArticleBtn.title = 'Impossibile visualizzare articoli: prodotto non selezionato';
      } else {
        // Se c'è product_id, assicurati che il button sia abilitato
        goToArticleBtn.disabled = false;
        goToArticleBtn.style.opacity = '1';
        goToArticleBtn.style.cursor = 'pointer';
        goToArticleBtn.title = 'Visualizza articoli del prodotto';
      }
    }
  }
});












