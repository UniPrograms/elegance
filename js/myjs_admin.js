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
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") {
          alert("Errore: " +  response.text_message);
        }
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
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") {
          alert("Errore: " +  response.text_message);
        }
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
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") {
          alert("Errore: " +  response.text_message);
        }
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
          }
          else if (response.status == "SESSION_ERROR") {
            alert("Errore: " +  response.text_message);
          }
          else if (response.status == "OPERATION_ERROR") {
            alert("Errore: " +  response.text_message);
          }
          else if (response.status == "GENERIC_ERROR") { 
            alert("Errore: " +  response.text_message);
          }
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
                }
                else if (response.status == "SESSION_ERROR") {
                  alert("Errore: " +  response.text_message);
                }
                else if (response.status == "OPERATION_ERROR") {
                  alert("Errore: " +  response.text_message);
                }
                else if (response.status == "GENERIC_ERROR") {  
                  alert("Errore: " +  response.text_message);
                }
            });
        });
    }

});



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
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") {
          alert("Errore: " +  response.text_message);
        }
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
            else if (response.status == "SESSION_ERROR") {
              alert("Errore: " +  response.text_message);
            }
            else if (response.status == "OPERATION_ERROR") {
              alert("Errore: " +  response.text_message);
            }
            else if (response.status == "GENERIC_ERROR") {
              alert("Errore: " +  response.text_message);
            }
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
                else if (response.status == "SESSION_ERROR") {
                  alert("Errore: " +  response.text_message);
                }
                else if (response.status == "OPERATION_ERROR") {
                  alert("Errore: " +  response.text_message);
                }
                else if (response.status == "GENERIC_ERROR") {
                  alert("Errore: " +  response.text_message);
                }
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
    
    // Ottieni il file selezionato
    const fileInput = document.getElementById("product-cover-img-file");
    const selectedFile = fileInput.files[0];

    // Crea FormData per inviare il file
    const formData = new FormData();
    
    if(productId.length != 0){
      formData.append("operation", "store");
      formData.append("product_id", productId);
      formData.append("product_name", productName);
      formData.append("product_price", productPrice);
      formData.append("product_description", productDescription);
      formData.append("brand_id", productBrandId);
      formData.append("category_id", productCategoryId);
      formData.append("sex_id", productSexId);
    }else{
      formData.append("operation", "store");
      formData.append("product_name", productName);
      formData.append("product_price", productPrice);
      formData.append("product_description", productDescription);
      formData.append("brand_id", productBrandId);
      formData.append("category_id", productCategoryId);
      formData.append("sex_id", productSexId);
    }
    
    // Aggiungi il file se è stato selezionato
    if(selectedFile){
      formData.append("product_image", selectedFile);
      console.log("[DEBUG] File selezionato:", selectedFile);
    } else {
      console.log("[DEBUG] Nessun file selezionato per la copertina");
    }

    $.ajax({
      type: "POST",
      url: "product_operation.php",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
    }).done(function(response){
      if(response.status == "OK"){
        // Aggiorna la copertina forzando il refresh (se presente)
        var coverImg = document.getElementById('product-cover-img');
        if(coverImg) {
          // Prendi la nuova url (stessa, ma aggiungi timestamp)
          var baseUrl = coverImg.src.split('?')[0];
          coverImg.src = baseUrl + '?t=' + new Date().getTime();
        }
        window.location.href = "admin_viewproduct.php?product_id=" + response.product_id;
        }
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") {
          alert("Errore: " +  response.text_message);
        }
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


// Gestione selezione immagine in admin_viewproduct
document.addEventListener('DOMContentLoaded', function(){
  // Controlla se siamo nella pagina admin_viewproduct.php
  if (window.location.pathname.includes('admin_viewproduct.php')) {
    
    const chooseFileBtn = document.getElementById('choose-cover-img-btn');
    const fileInput = document.getElementById('product-cover-img-file');
    
    if (chooseFileBtn && fileInput) {
      
      // Gestione click sul pulsante "Scegli il file"
      chooseFileBtn.addEventListener('click', function() {
        fileInput.click(); // Apre il file dialog
      });
      
      // Gestione selezione file
      fileInput.addEventListener('change', function() {
        const file = this.files[0];
        
        if (file) {
          // Validazione tipo file (solo immagini)
          if (!file.type.startsWith('image/')) {
            alert('Seleziona solo file immagine (JPG, PNG, GIF, etc.)');
            this.value = ''; // Pulisce la selezione
            return;
          }
          
          // Validazione dimensione file (max 5MB)
          const maxSize = 5 * 1024 * 1024; // 5MB in bytes
          if (file.size > maxSize) {
            alert('Il file è troppo grande. Dimensione massima: 5MB');
            this.value = '';
            return;
          }
          
          // Popola l'input con il nome del file
          const pathInput = document.getElementById('cover-img-file-path');
          if (pathInput) {
            pathInput.value = file.name;
          }
          
          
        } else {
          // Nessun file selezionato
          alert('Nessun file selezionato');
        }
      });
    }
  }
});


// Funzione per rimuovere un'immagine caricata o già esistente
function removeUploadedImg(btn) {
  var wrapper = btn.closest('.img-uploaded-wrapper');
  if (wrapper && wrapper.parentNode) {
    var imgTag = wrapper.querySelector('img');
    if (!imgTag) return;
    var imageId = imgTag.getAttribute('value');
    if (!imageId) {
      alert('ID immagine non trovato!');
      return;
    }

    // Chiamata AJAX per eliminare l'immagine
    $.ajax({
      url: 'image_operation.php',
      type: 'POST',
      data: {
        operation: 'delete',
        image_id: imageId
      },
      dataType: 'json'
    }).done(function(response){
      if(response.status == "OK"){
        location.reload(true);
      }
      else if (response.status == "SESSION_ERROR") {
        alert("Errore: " +  response.text_message);
      }
      else if (response.status == "OPERATION_ERROR") {
        alert("Errore: " +  response.text_message);
      }
      else if (response.status == "GENERIC_ERROR") {
        alert("Errore: " +  response.text_message);
      }
    });
  }
}

// Collega la X rossa anche alle immagini già presenti (inserite da PHP)
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.img-uploaded-wrapper .delete-img-btn').forEach(function(btn) {
    btn.addEventListener('click', function(ev) {
      ev.stopPropagation();
      removeUploadedImg(this);
    });
  });
});


// Modifica la logica di upload per usare la stessa funzione di rimozione
// Gestione upload immagini prodotto in admin_viewproduct.html (versione con + su ogni placeholder e X per cancellare)
document.addEventListener('DOMContentLoaded', function () {
  var imgInput = document.getElementById('product-images-input');
  var imgPanel = document.querySelector('.product-image-panel > div');
  var currentTargetPlaceholder = null;

  if (imgInput && imgPanel) {
    imgPanel.querySelectorAll('.add-img-btn').forEach(function(btn) {
      btn.onclick = null;
      btn.addEventListener('click', function (e) {
        currentTargetPlaceholder = btn.parentNode;
        imgInput.value = '';
        imgInput.click();
      });
    });

    imgInput.onchange = null;
    imgInput.addEventListener('change', function (e) {
      var files = Array.from(e.target.files);
      if (!files.length || !currentTargetPlaceholder) return;
      var file = files[0];

      var urlParams = new URLSearchParams(window.location.search);
      var productId = urlParams.get('product_id');
      if (!productId) {
        alert('ID prodotto non trovato!');
        return;
      }

      // Usa FormData per inviare anche il file
      var formData = new FormData();
      formData.append('operation', 'store');
      formData.append('product_id', productId);
      formData.append('image_url', file.name); // opzionale, se vuoi anche il nome
      formData.append('image', file); // qui invii il file vero e proprio

      $.ajax({
        url: 'image_operation.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json'
      }).done(function(response){
        if(response.status == "OK"){
          location.reload(true);
        } 
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") {
          alert("Errore: " +  response.text_message);
        }
      });
      imgInput.value = '';
    });
  }
});


// Solo anteprima immagine copertina, nessun salvataggio
document.addEventListener('DOMContentLoaded', function() {
  if (window.location.pathname.includes('admin_viewproduct.php')) {
    const fileInput = document.getElementById('product-cover-img-file');
    if (fileInput) {
      fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function(e) {
            // Aggiorna solo l'anteprima dell'immagine di copertina
            const img = document.querySelector('.img-placeholder-upload img');
            if (img) img.src = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      });
    }
  }
});


// Disabilita i bottoni per aggiungere foto se la query string è vuota in admin_viewproduct.php
document.addEventListener('DOMContentLoaded', function() {
  if (window.location.pathname.includes('admin_viewproduct.php')) {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('product_id');
    if (!productId) {
      // Disabilita solo i bottoni per aggiungere altre immagini
      document.querySelectorAll('.add-img-btn').forEach(function(btn) {
        btn.disabled = true;
        btn.style.opacity = '0.5';
        btn.style.cursor = 'not-allowed';
        btn.title = 'Seleziona prima un prodotto';
      });
    }
  }
});



// ############ CATEGORIA ############

// Reindirizzamento alla pagina per aggiornare una categoria
document.addEventListener('DOMContentLoaded', function () {  

  document.querySelectorAll('.admin-details-categories').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var categoryId = this.getAttribute("value");
      window.location.href = "admin_viewcategory.php?category_id="+categoryId;
      
    });
  });
});



// Reindirizzamento alla pagina per aggiungere una nuova categoria
document.addEventListener('DOMContentLoaded', function(){

  const addNewProductBtn = document.getElementById('admin-add-new-category');

  addNewProductBtn.addEventListener("click", function(btn){
    window.location.href = "admin_viewcategory.php";
  });

});



// Aggiornamento dati categoria
document.addEventListener('DOMContentLoaded', function(){

  const updateBtn = document.getElementById("admin-update-category");
  
  updateBtn.addEventListener("click", function(btn){

    const categoryName = document.getElementById("category-name").value;
    const params = new URLSearchParams(window.location.search);
    const categoryId = params.get("category_id");

    if(categoryId == null){
      data = { category_name: categoryName, operation: "store"};
    }
    else{
      data = {category_id: categoryId, category_name: categoryName, operation: "store"};
    }


     $.ajax({
      type: "POST",
      url: "category_operation.php",
      data: data,
      dataType: "json",
    }).done(function (response) { 

        if(response.status == "OK"){
          window.location.href = "admin_viewcategory.php?category_id=" + response.category_id;
        }
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") { 
          alert("Errore: " +  response.text_message);
        }
    });
  });
});



// Controllo delete eliminazione categoria
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.admin-delete-categories').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var categoryId = this.getAttribute("value");
      var row = this.closest("tr");
      $.ajax({
        type: "POST",
        url: "category_operation.php",
        data: {
          category_id: categoryId,
          operation: "delete",
        },
        dataType: "json",
      }).done(function(response){

        if(response.status == "OK"){
          
          $(row).fadeOut(400, function() {
            $(this).remove();
          });

        }
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") {
          alert("Errore: " +  response.text_message);
        }
      });
    });
  });
});


// Aggiornamento table delle categorie tramite search bar categorie
document.addEventListener('DOMContentLoaded', function(){

  const searchBar = document.getElementById('searchbar-category');

    searchBar.addEventListener('keydown',  function(e) {
      if (e.key === 'Enter') {
        const value = e.target.value;
        window.location.href = "admin_categories.php?filter_string="+value;
      }
    });

});


// ############ PRODUTTORE ############


// Reindirizzamento alla pagina per aggiornare un produttore
document.addEventListener('DOMContentLoaded', function () {  

  document.querySelectorAll('.admin-details-brands').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var productorId = this.getAttribute("value");
      window.location.href = "admin_viewbrand.php?productor_id="+productorId;
      
    });
  });
});


// Reindirizzamento alla pagina per aggiungere una nuovo produttore
document.addEventListener('DOMContentLoaded', function(){

  const addNewProductBtn = document.getElementById('admin-add-new-brand');

  addNewProductBtn.addEventListener("click", function(btn){
    window.location.href = "admin_viewbrand.php";
  });

});


// Controllo delete eliminazione produttore
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.admin-delete-brands').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var productorId = this.getAttribute("value");
      var row = this.closest("tr");
      $.ajax({
        type: "POST",
        url: "productor_operation.php",
        data: {
          productor_id: productorId,
          operation: "delete",
        },
        dataType: "json",
      }).done(function(response){

        if(response.status == "OK"){
          
          $(row).fadeOut(400, function() {
            $(this).remove();
          });

        }
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") {
          alert("Errore: " +  response.text_message);
        }
      });
    });
  });
});


// Aggiornamento table dei produttori tramite search bar produttore
document.addEventListener('DOMContentLoaded', function(){

  const searchBar = document.getElementById('searchbar-brand');

    searchBar.addEventListener('keydown',  function(e) {
      if (e.key === 'Enter') {
        const value = e.target.value;
        window.location.href = "admin_brands.php?filter_string="+value;
      }
    });

});



// ############ NAZIONE ############

// Reindirizzamento alla pagina per aggiornare una nazione
document.addEventListener('DOMContentLoaded', function () {  

  document.querySelectorAll('.admin-details-country').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var countryId = this.getAttribute("value");
      window.location.href = "admin_viewcountry.php?country_id="+countryId;
      
    });
  });
});



// Reindirizzamento alla pagina per aggiungere una nuova nazione
document.addEventListener('DOMContentLoaded', function(){

  const addNewProductBtn = document.getElementById('admin-add-new-country');

  addNewProductBtn.addEventListener("click", function(btn){
    window.location.href = "admin_viewcountry.php";
  });

});


// Aggiornamento dati categoria
document.addEventListener('DOMContentLoaded', function(){

  const updateBtn = document.getElementById("admin-update-country");
  
  updateBtn.addEventListener("click", function(btn){

    const countryName = document.getElementById("country-name").value;
    const params = new URLSearchParams(window.location.search);
    const countryId = params.get("country_id");

    if(countryId == null){
      data = { country_name: countryName, operation: "store"};
    }
    else{
      data = {country_id: countryId, country_name: countryName, operation: "store"};
    }


     $.ajax({
      type: "POST",
      url: "country_operation.php",
      data: data,
      dataType: "json",
    }).done(function (response) { 

        if(response.status == "OK"){
          window.location.href = "admin_viewcountry.php?country_id=" + response.country_id;
        }
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") { 
          alert("Errore: " +  response.text_message);
        }
    }).fail(function(xhr, status, error) {
        console.error("[AJAX FAIL] Errore nella richiesta di salvataggio country:", {
          xhr: xhr,
          status: status,
          error: error,
          responseText: xhr && xhr.responseText ? xhr.responseText : null
        });
        alert("Errore di comunicazione col server. Controlla la console per dettagli.");
    });
  });
});




// Controllo delete eliminazione nazione
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.admin-delete-country').forEach(function(btn) {
    btn.addEventListener('click', function() {

      var countryId = this.getAttribute("value");
      var row = this.closest("tr");
      $.ajax({
        type: "POST",
        url: "country_operation.php",
        data: {
          country_id: countryId,
          operation: "delete",
        },
        dataType: "json",
      }).done(function(response){

        if(response.status == "OK"){
          
          $(row).fadeOut(400, function() {
            $(this).remove();
          });

        }
        else if (response.status == "SESSION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "OPERATION_ERROR") {
          alert("Errore: " +  response.text_message);
        }
        else if (response.status == "GENERIC_ERROR") {
          alert("Errore: " +  response.text_message);
        }
      });
    });
  });
});


// Aggiornamento table delle nazioni tramite search bar nazione
document.addEventListener('DOMContentLoaded', function(){

  const searchBar = document.getElementById('searchbar-country');

    searchBar.addEventListener('keydown',  function(e) {
      if (e.key === 'Enter') {
        const value = e.target.value;
        window.location.href = "admin_countries.php?filter_string="+value;
      }
    });

});


// Gestione selezione immagine in admin_viewbrand (admin_viewproductor)
document.addEventListener('DOMContentLoaded', function(){
  if (window.location.pathname.includes('admin_viewbrand.php')) {
    const chooseFileBtn = document.getElementById('choose-cover-img-btn');
    const fileInput = document.getElementById('brand-cover-img-file');
    const pathInput = document.getElementById('cover-img-file-path');
    const imgPreview = document.getElementById('brand-cover-img');

    if (chooseFileBtn && fileInput) {
      // Click su "Scegli il file"
      chooseFileBtn.addEventListener('click', function() {
        fileInput.click();
      });

      // Selezione file
      fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
          // Mostra il nome file nell'input
          if (pathInput) {
            pathInput.value = file.name;
          }
          // Mostra anteprima immagine
          if (imgPreview) {
            const reader = new FileReader();
            reader.onload = function(e) {
              imgPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
          }
        } else {
          if (pathInput) pathInput.value = '';
          if (imgPreview) imgPreview.src = '';
        }
      });
    }
  }
});


// Gestione salvataggio brand (admin_viewbrand) - parametri come nel PHP e blocco done/fail
document.addEventListener('DOMContentLoaded', function(){
  if (window.location.pathname.includes('admin_viewbrand.php')) {
    const saveBtn = document.getElementById('admin-update-brand');
    if (saveBtn) {
      saveBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const brandName = document.getElementById('brand-name-input').value;
        const brandIdInput = document.getElementById('brand-id');
        const brandId = brandIdInput && brandIdInput.value ? brandIdInput.value : '';
        const fileInput = document.getElementById('brand-cover-img-file');
        const selectedFile = fileInput && fileInput.files.length > 0 ? fileInput.files[0] : null;

        var formData = new FormData();
        formData.append('productor_name', brandName);
        if (selectedFile) {
          formData.append('productor_logo', selectedFile);
        }
        formData.append('productor_id', brandId);
        formData.append('operation', 'store');

        $.ajax({
          type: 'POST',
          url: 'productor_operation.php',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
        }).done(function(response) {
          if(response.status == 'OK') {
            window.location.href = 'admin_viewbrand.php?productor_id=' + response.productor_id;
          } else if (response.status == 'SESSION_ERROR') {
            alert('Errore: ' + response.text_message);
          } else if (response.status == 'OPERATION_ERROR') {
            alert('Errore: ' + response.text_message);
          } else if (response.status == 'GENERIC_ERROR') {
            alert('Errore: ' + response.text_message);
            console.error('Errore AJAX brand:', response);
          }
        }).fail(function(xhr, status, error) {
          console.error('[AJAX FAIL] Errore nella richiesta di salvataggio brand:', {
            xhr: xhr,
            status: status,
            error: error,
            responseText: xhr && xhr.responseText ? xhr.responseText : null
          });
          alert('Errore di comunicazione col server. Controlla la console per dettagli.');
        });
      });
    }
  }
});

// Blocco salvataggio se il nome categoria è vuoto in admin_viewcategory
document.addEventListener('DOMContentLoaded', function(){
  if (window.location.pathname.includes('admin_viewcategory.php')) {
    const saveBtn = document.getElementById('admin-update-category');
    if (saveBtn) {
      saveBtn.addEventListener('click', function(e) {
        const categoryName = document.getElementById('category-name');
        if (!categoryName || !categoryName.value.trim()) {
          e.preventDefault();
          alert('Il nome della categoria non può essere vuoto!');
          categoryName.focus();
          return false;
        }
      });
    }
  }
});

// Blocco salvataggio se il nome country è vuoto in admin_viewcountry

document.addEventListener('DOMContentLoaded', function(){
  if (window.location.pathname.includes('admin_viewcountry.php')) {
    const saveBtn = document.getElementById('admin-update-country');
    if (saveBtn) {
      saveBtn.addEventListener('click', function(e) {
        const countryName = document.getElementById('country-name');
        if (!countryName || !countryName.value.trim()) {
          e.preventDefault();
          alert('Il nome del paese non può essere vuoto!');
          countryName.focus();
          return false;
        }
      });
    }
  }
});

// Blocco salvataggio se i campi obbligatori sono vuoti in admin_viewuser

document.addEventListener('DOMContentLoaded', function(){
  if (window.location.pathname.includes('admin_viewuser.php')) {
    const saveBtn = document.getElementById('admin-update-user');
    if (saveBtn) {
      saveBtn.addEventListener('click', function(e) {
        const userName = document.getElementById('user-name');
        const userSurname = document.getElementById('user-surname');
        const userRole = document.getElementById('user-role-input');
        const userPhone = document.getElementById('user-phone');

        if (!userName || !userName.value.trim()) {
          e.preventDefault();
          alert('Il nome non può essere vuoto!');
          userName.focus();
          return false;
        }
        if (!userSurname || !userSurname.value.trim()) {
          e.preventDefault();
          alert('Il cognome non può essere vuoto!');
          userSurname.focus();
          return false;
        }
        if (!userRole || !userRole.value.trim()) {
          e.preventDefault();
          alert('Il ruolo non può essere vuoto!');
          userRole.focus();
          return false;
        }
        // La logica per il telefono è già implementata altrove (deve essere vuoto o di 10 cifre)
      });
    }
  }
});



