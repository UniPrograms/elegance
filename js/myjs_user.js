// Funzione per mostrare alert su click "Sposta nel carrello" dalla wishlist
document.addEventListener('DOMContentLoaded', function() {
  // Selettore per tutti i bottoni "Sposta nel carrello" dalla wishlist
  document.querySelectorAll('.move-to-cart-item').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var itemId = this.getAttribute("value");

      $.ajax({
        type: "POST",
        url: "wishlist_operation.php",
        data: {
          item_id: itemId,
          operation: "move",
        },
        dataType: "json",
      }).done(function(response){

          if(response.status == "OK"){
            var cart_size = response.cart_item_size;
            var wishlist_size = response.wishlist_item_size;
            
            if(wishlist_size <= 0){
              window.location.href = "wishlist.php";
              return;
            }
            else{
              // Aggiorna il badge del carrello nell'header
              var headerBadge = document.querySelector('#essenceCartBt span');
              if(headerBadge && typeof cart_size !== "undefined") {
                headerBadge.textContent = cart_size;
              }
              // Fai scomparire lentamente la riga dell'item
              var row = btn.closest('tr');
              if(row) {
                row.style.transition = 'opacity 0.5s';
                row.style.opacity = 0;
                setTimeout(function() {
                  row.remove();
                }, 500);
              }
            }

          }
          else if(response.status == "SESSION_ERROR"){
            alert("Errore: " + response.text_message);
          }
          else if(response.status == "OPERATION_ERROR"){
            alert("Errore: " + response.text_message);
          }
          else if(response.status == "GENERIC_ERROR"){
            alert("Errore: " + response.text_message);
          }
      });
    });
  });

  // Selettore per tutti i bottoni "Rimuovi dalla wishlist"
  document.querySelectorAll('.remove-wishlist-item').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var itemId = this.getAttribute("value");

      $.ajax({
        type: "POST",
        url: "wishlist_operation.php",
        data: {
          item_id: itemId,
          operation: "delete",
        },
        dataType: "json",
      }).done(function(response){

          if(response.status == "OK"){
            var cart_size = response.cart_item_size;
            var wishlist_size = response.wishlist_item_size;
            
            if(wishlist_size <= 0){
              window.location.href = "wishlist.php";
              return;
            }
            else{
              // Aggiorna il badge del carrello nell'header
              var headerBadge = document.querySelector('#essenceCartBt span');
              if(headerBadge && typeof cart_size !== "undefined") {
                headerBadge.textContent = cart_size;
              }
              // Fai scomparire lentamente la riga dell'item
              var row = btn.closest('tr');
              if(row) {
                row.style.transition = 'opacity 0.5s';
                row.style.opacity = 0;
                setTimeout(function() {
                  row.remove();
                }, 500);
              }
            }

          }
          else{
            alert("Errore: " + response.text_message);
          }
      });
    });
  });
});


// Gestione rimozione articolo dal carrello
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.remove-cart-item').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      var cartItemId = btn.value;
      if (!cartItemId) return;

      $.ajax({
        type: "POST",
        url: "cart_operation.php",
        data: {
          operation: "delete",
          cart_item_id: cartItemId
        },
        dataType: "json",
      }).done(function(response) {
        if (response.status == "OK") {
          // Aggiorna badge header
          var headerBadge = document.querySelector('#essenceCartBt span');
          if (headerBadge && typeof response.counter !== "undefined") {
            headerBadge.textContent = response.counter;
          }

          // Aggiorna numero articoli nella pagina carrello
          var cartTotal = document.querySelector('.cart-summary .list-group-item span');
          if (cartTotal && typeof response.counter !== "undefined") {
            cartTotal.textContent = response.counter;
          }

          // Aggiorna prezzo totale
          if (typeof response.total_price !== "undefined") {
            var priceSpan = document.querySelector('.cart-summary .font-weight-bold');
            if (priceSpan) {
              priceSpan.textContent = response.total_price + ' $';
            }
          }

          // Se il carrello è vuoto, reindirizza a cart.php
          if (response.counter == 0) {
            window.location.href = 'cart.php';
            return;
          }

          // Rimuovi la riga con effetto dissolvenza
          var row = btn.closest('tr');
          if (row) {
            row.style.transition = 'opacity 0.5s';
            row.style.opacity = 0;
            setTimeout(function() {
              row.remove();
            }, 500);
          }

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


// Colora i quadrati dei colori nella shop sidebar in base all'attributo name
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.color_shop').forEach(function(el) {
    var colorName = el.getAttribute('color-name');
    if (colorName) {
      // Gestione nomi standardizzati (case insensitive)
      var cssColor = colorName.toLowerCase();
      // Eventuale mappatura nomi DB -> CSS
      var colorMap = {
        'black': 'black',
        'white': 'white',
        'red': 'red',
        'blue': 'blue',
        'pink': 'pink',
        'yellow': 'yellow',
        'orange': 'orange',
        'green': 'green',
        'purple': 'purple',
        'brown': 'brown',
        'gray': 'gray',
        'beige': 'beige'
      };
      if (colorMap[cssColor]) {
        el.style.backgroundColor = colorMap[cssColor];
      } else {
        el.style.backgroundColor = cssColor; // fallback: prova col nome diretto
      }
      el.style.display = 'inline-block';
      el.style.width = '24px';
      el.style.height = '24px';
      el.style.borderRadius = '50%';
      el.style.border = '1px solid #ccc';
      el.style.margin = '2px';
      el.style.cursor = 'pointer'; // Aggiunge il cursore pointer per indicare che è cliccabile
    }
  });
});

// Gestione selezione colori nella shop sidebar
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.color_shop').forEach(function(el) {
    el.addEventListener('click', function(e) {
      e.preventDefault(); // Previene la navigazione del link
      
      var colorValue = this.getAttribute('value');
      var colorIdInput = document.querySelector('input[name="color_id"]');
      
      // Se il colore cliccato è già selezionato (stesso valore nel campo nascosto)
      if (colorIdInput && colorValue && colorIdInput.value == colorValue) {
        // Deseleziona il colore
        this.classList.remove('selected');
        // Metti 0 nel campo nascosto
        colorIdInput.value = '0';
      } else {
        // Rimuovi la selezione da tutti gli altri colori
        document.querySelectorAll('.color_shop').forEach(function(otherEl) {
          otherEl.classList.remove('selected');
        });
        
        // Seleziona il colore cliccato
        this.classList.add('selected');
        
        // Aggiorna il campo nascosto con il valore del colore
        if (colorIdInput && colorValue) {
          colorIdInput.value = colorValue;
        }
      }
    });
  });
});


// Validazione e invio dati checkout su "Place Order"
document.addEventListener('DOMContentLoaded', function() {
  var checkoutForm = document.querySelector('form[action*="order_operation.php"]');
  if (!checkoutForm) return;
  checkoutForm.addEventListener('submit', function(e) {
    // Campi obbligatori (tranne telefono e civico)
    var requiredFields = [
      'first_name',
      'last_name',
      'email_address',
      'country',
      'street_address',
      'postcode',
      'city',
      'state'
    ];
    var valid = true;
    requiredFields.forEach(function(id) {
      var el = document.getElementById(id);
      if (!el || !el.value || el.value.trim() === '') {
        valid = false;
        el && el.classList.add('is-invalid');
      } else {
        el.classList.remove('is-invalid');
      }
    });
    // Validazione numero di telefono (deve essere 0 o 10 cifre)
    var phoneField = document.getElementById('phone_number');
    var phoneError = '';
    if (phoneField && phoneField.value.trim() !== '') {
      var phoneValue = phoneField.value.replace(/\s/g, ''); // Rimuovi spazi
      if (phoneValue.length !== 10) {
        valid = false;
        phoneField.classList.add('is-invalid');
        phoneError = 'Il numero di telefono deve essere di 10 cifre o lasciato vuoto.';
      } else {
        phoneField.classList.remove('is-invalid');
      }
    } else {
      phoneField.classList.remove('is-invalid');
    }
    
    // Metodo di pagamento obbligatorio
    var payment = document.querySelector('input[name="payment_method"]:checked');
    if (!payment) {
      valid = false;
      var opts = document.querySelectorAll('.payment-method-option');
      opts.forEach(function(opt) { opt.classList.add('is-invalid'); });
    } else {
      var opts = document.querySelectorAll('.payment-method-option');
      opts.forEach(function(opt) { opt.classList.remove('is-invalid'); });
    }
    
    if (!valid) {
      e.preventDefault();
      // Mostra il primo errore incontrato
      if (phoneError) {
        alert(phoneError);
      } else {
        alert('Compila tutti i campi obbligatori.');
      }
      return false;
    }
    // Se tutti i campi sono validi, lascia proseguire il submit normale
  });
});


// Evidenzia il metodo di pagamento selezionato (checkout)
document.addEventListener('DOMContentLoaded', function() {
  var paymentOptions = document.querySelectorAll('.payment-method-option');
  paymentOptions.forEach(function(option) {
    var radio = option.querySelector('input[type="radio"]');
    // Se già selezionato all'avvio
    if (radio && radio.checked) {
      option.classList.add('selected');
    }
    option.addEventListener('click', function(e) {
      paymentOptions.forEach(function(opt) {
        opt.classList.remove('selected');
        var r = opt.querySelector('input[type="radio"]');
        if (r) r.checked = false;
      });
      if (radio) {
        radio.checked = true;
        option.classList.add('selected');
      }
    });
    // Accessibilità: selezione anche con tastiera
    option.addEventListener('keydown', function(e) {
      if (e.key === ' ' || e.key === 'Enter') {
        option.click();
      }
    });
  });
});


// Evidenzia le notifiche non lette in base al campo nascosto
document.addEventListener('DOMContentLoaded', function() {
  var notificationCards = document.querySelectorAll('.notification-card');
  notificationCards.forEach(function(card) {
    var statusInput = card.querySelector('.notification-read-status');
    if (statusInput && statusInput.value === 'unread') {
      card.classList.add('unread');
      var badge = card.querySelector('.notification-badge');
      if (badge) {
        badge.classList.add('unread');
        badge.textContent = 'Nuova';
      }
    } else {
      card.classList.remove('unread');
      var badge = card.querySelector('.notification-badge');
      if (badge) {
        badge.classList.remove('unread');
        badge.textContent = 'Letta';
      }
    }
  });
});


// Anteprima dell'avatar della foto nel profilo utente al momento del caricamento
const upload = document.getElementById('ct-profile-upload');
const preview = document.getElementById('ct-profile-img-preview');
if(upload && preview) {
  upload.addEventListener('change', function(e) {
    if (upload.files && upload.files[0]) {
      const reader = new FileReader();
      reader.onload = function(ev) {
        preview.src = ev.target.result;
        // Invio AJAX a user_operation.php con l'URL base64 dell'immagine
      
        $.ajax({
          type: 'POST',
          url: 'user_operation.php',
          data: { 
            image_url: ev.target.result,
            operation: 'upload-image',
          },
          dataType: "json",
        }).done(function(response){
            if(response.status == "OK"){
              // Non succede nulla
            }
            else{
              alert("Error: " + response.text_message);
            }
        });
      };
      reader.readAsDataURL(upload.files[0]);
      location.reload();
    }
  });
}


// Gestione submit form prodotto
document.addEventListener('DOMContentLoaded', function() {
  var productForm = document.getElementById('add-to-cart-form');
  if (!productForm) return;

  productForm.addEventListener('submit', function(e) {
    e.preventDefault();

    // Non succede nulla se il button è disabilitato
    var buttonAddToCart = document.querySelector('#btn-add-to-cart');
    if (buttonAddToCart.disabled || buttonAddToCart.classList.contains('disabled')) return; 
  

    // Prendo i parametri
    var productId = productForm.querySelector('input[name="product_id"]')?.value;
    var sizeInput = productForm.querySelector('select[name="size_id"]');
    var sizeId = sizeInput ? sizeInput.value : '';
    var colorInput = productForm.querySelector('select[name="color_id"]');
    var colorId = colorInput ? colorInput.value : '';
    
    $.ajax({
      type: "POST",
      url:"cart_operation.php",
      data:{
        operation: "store",
        product_id: productId,
        size_id: sizeId,
        color_id: colorId,
      },
      dataType: "json",
    }).done(function(response){

      if(response.status == "OK"){
        var cart_size = response.cart_item_size;
        var article_qty = response.article_qty;

        // Aggiorno il badge del carrello nell'header
        var headerBadge = document.querySelector('#essenceCartBt span');
        if(headerBadge && typeof cart_size !== "undefined") headerBadge.textContent = cart_size;
        

        // Aggiorno la label e il button in base alla quantità dell'articolo
        var labelAvailable = document.querySelector('#available-label');
        var buttonAddToCart = document.querySelector('#btn-add-to-cart');
        
        if(labelAvailable && typeof article_qty !== "undefined" && article_qty <= 0 ){
          labelAvailable.setAttribute("class","alert alert-danger font-weight-bold product-ended-alert");
          buttonAddToCart.setAttribute("class","btn essence-btn disabled");   
        }

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


// Gestione del badge di prodotto terminato all'avvio della pagina
document.addEventListener('DOMContentLoaded', function () {
  if (window.location.pathname.includes('product.php')) {
    
    // Prendo la form
    var productForm = document.getElementById('add-to-cart-form');
    if(!productForm) return;

    // Ottengo i valori
    const productId = productForm.querySelector('input[name="product_id"]')?.value;
    const sizeId = productForm.querySelector('select[name="size_id"]')?.value;
    const colorId = productForm.querySelector('select[name="color_id"]')?.value

     $.ajax({
      type: "POST",
      url:"article_operation.php",
      data:{
        operation: "count",
        product_id: productId,
        size_id: sizeId,
        color_id: colorId,
      },
      dataType: "json",
    }).done(function(response){

        if(response.status == 'OK'){
          var article_qty = response.article_qty;

          // Aggiorno la label e il button in base alla quantità dell'articolo
          var labelAvailable = document.querySelector('#available-label');
          var buttonAddToCart = document.querySelector('#btn-add-to-cart');
        
          if(labelAvailable && typeof article_qty !== "undefined" && article_qty <= 0 ){
            labelAvailable.setAttribute("class","alert alert-danger font-weight-bold product-ended-alert");
            buttonAddToCart.setAttribute("class","btn essence-btn disabled");   
          }
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
});


// Gestione del badge di prodotto al momento  della selezione della taglia/colore 
document.addEventListener('DOMContentLoaded', function() {
  const productIdInput = document.querySelector('input[name="product_id"]');
  const sizeSelect = document.getElementById('productSize');
  const colorSelect = document.getElementById('productColor');

  const customSelects = document.querySelectorAll('.nice-select');

  customSelects.forEach(function(customSelect) {
    customSelect.addEventListener('click', function(event) {
      const clickedElem = event.target;

      if (clickedElem.classList.contains('option')) {
        setTimeout(function() {
          const productId = productIdInput ? productIdInput.value : null;
          const sizeId = sizeSelect ? sizeSelect.value : null;
          const colorId = colorSelect ? colorSelect.value : null;


          // Esegui la chiamata AJAX jQuery
          $.ajax({
            type: "POST",
            url: "article_operation.php",
            data: {
              operation: "count",
              product_id: productId,
              size_id: sizeId,
              color_id: colorId,
            },
            dataType: "json",
          }).done(function(response) {
            if (response.status === 'OK') {
              const article_qty = response.article_qty;

              const labelAvailable = document.querySelector('#available-label');
              const buttonAddToCart = document.querySelector('#btn-add-to-cart');

              if (labelAvailable && typeof article_qty !== "undefined" && article_qty <= 0) {
                labelAvailable.setAttribute("class", "alert alert-danger font-weight-bold product-ended-alert");
                if (buttonAddToCart) {
                  buttonAddToCart.setAttribute("class", "btn essence-btn disabled");
                }
              } else {
                // Se quantità > 0, eventualmente ripristina lo stato attivo
                if (labelAvailable) {
                  labelAvailable.setAttribute("class", "alert alert-danger font-weight-bold product-ended-alert-hidden"); // O la classe originale
                }
                if (buttonAddToCart) {
                  buttonAddToCart.setAttribute("class", "btn essence-btn");
                }
              }
            } 
            else if(response.status == "SESSION_ERROR") {
              alert("Errore: " + response.text_message);
            }
            else if(response.status == "OPERATION_ERROR") {
              alert("Errore: " + response.text_message);
            }
            else if(response.status == "GENERIC_ERROR") {
              alert("Errore: " + response.text_message);
            }
          });
        });
      }
    });
  });
});


// Gestione del colore del cuore all'avvio della pagina
document.addEventListener('DOMContentLoaded', function () {
  if (window.location.pathname.includes('product.php')) {
    
    // Prendo la form
    var productForm = document.getElementById('add-to-cart-form');
    if(!productForm) return;

    // Ottengo i valori
    const productId = productForm.querySelector('input[name="product_id"]')?.value;
    const sizeId = productForm.querySelector('select[name="size_id"]')?.value;
    const colorId = productForm.querySelector('select[name="color_id"]')?.value

     $.ajax({
      type: "POST",
      url:"wishlist_operation.php",
      data:{
        operation: "is_present",
        product_id: productId,
        size_id: sizeId,
        color_id: colorId,
      },
      dataType: "json",
    }).done(function(response){

        if(response.status == 'OK'){
           var favHeart = document.getElementById('add-to-wishlist');
              if (response.is_present == "true") {
                favHeart.classList.remove('heart-grey');
                favHeart.classList.add('heart-red');
              } else {
                favHeart.classList.remove('heart-red');
                favHeart.classList.add('heart-grey');
              }
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
});


// Gestione del colore del cuore al momento della selezione della taglia/colore
document.addEventListener('DOMContentLoaded', function() {
  const productIdInput = document.querySelector('input[name="product_id"]');
  const sizeSelect = document.getElementById('productSize');
  const colorSelect = document.getElementById('productColor');

  const customSelects = document.querySelectorAll('.nice-select');

  customSelects.forEach(function(customSelect) {
    customSelect.addEventListener('click', function(event) {
      const clickedElem = event.target;

      if (clickedElem.classList.contains('option')) {
        setTimeout(function() {
          const productId = productIdInput ? productIdInput.value : null;
          const sizeId = sizeSelect ? sizeSelect.value : null;
          const colorId = colorSelect ? colorSelect.value : null;


          // Esegui la chiamata AJAX jQuery
          $.ajax({
            type: "POST",
            url: "wishlist_operation.php",
            data: {
              operation: "is_present",
              product_id: productId,
              size_id: sizeId,
              color_id: colorId,
            },
            dataType: "json",
          }).done(function(response) {
            if (response.status === 'OK') {
              var favHeart = document.getElementById('add-to-wishlist');
              if (response.is_present == "true") {
                favHeart.classList.remove('heart-grey');
                favHeart.classList.add('heart-red');
              } else {
                favHeart.classList.remove('heart-red');
                favHeart.classList.add('heart-grey');
              }
            }
            else if(response.status == "SESSION_ERROR") {
              alert("Errore: " + response.text_message);
            }
            else if(response.status == "OPERATION_ERROR") {
              alert("Errore: " + response.text_message);
            }
            else if(response.status == "GENERIC_ERROR") {
              alert("Errore: " + response.text_message);
            }
          });
        });
      }
    });
  });
});


// Gestione dell'inserimento (e rimozione) di un articolo all'interno della wishlist
document.addEventListener('DOMContentLoaded', function() {
  const favHeart = document.getElementById('add-to-wishlist');

  if (favHeart) {
    favHeart.addEventListener('click', function(event) {
      event.preventDefault();
 
      var operation = this.className == 'heart-grey' ? "store" : "delete";

      const productId = document.querySelector('input[name="product_id"]').value;
      const sizeSelect = document.getElementById('productSize');
      const sizeId = sizeSelect ? sizeSelect.value : null;
      const colorSelect = document.getElementById('productColor');
      const colorId = colorSelect ? colorSelect.value : null;

      
      $.ajax({
        type: "POST",
        url: "wishlist_operation.php",
        data: {
          operation: operation,
          product_id: productId,
          size_id: sizeId,
          color_id: colorId,
        },
        dataType: "json",
      }).done(function (response) {  
        // Cambia il colore del cuore in base al suo stato attuale (effetto toggle)
        if(response.status == "OK"){
          var favHeart = document.getElementById('add-to-wishlist');
              if (favHeart.classList.contains('heart-grey')) {
                favHeart.classList.remove('heart-grey');
                favHeart.classList.add('heart-red');
              } else {
                favHeart.classList.remove('heart-red');
                favHeart.classList.add('heart-grey');
              }
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


// Validazione numero di telefono nel form personal info
document.addEventListener('DOMContentLoaded', function() {
  var personalInfoForm = document.querySelector('.ct-profile-info-form');
  if (!personalInfoForm) return;
  
  personalInfoForm.addEventListener('submit', function(e) {
    var phoneField = document.getElementById('user_phone');
    if (phoneField && phoneField.value.trim() !== '') {
      var phoneValue = phoneField.value.replace(/\s/g, ''); // Rimuovi spazi
      if (phoneValue.length !== 10) {
        e.preventDefault();
        alert('Il numero di telefono deve essere di 10 cifre o lasciato vuoto.');
        return false;
      }
    }
    // Se la validazione passa, lascia proseguire il submit normale
  });
});


// Autoselezione colore nella shop sidebar in base al value dell'input nascosto
// (deve essere dopo che i colori sono stati renderizzati)
document.addEventListener('DOMContentLoaded', function() {
  var colorIdInput = document.querySelector('input[name="color_id"]');
  if (colorIdInput && colorIdInput.value && colorIdInput.value !== '0') {
    document.querySelectorAll('.color_shop').forEach(function(el) {
      if (el.getAttribute('value') === colorIdInput.value) {
        el.classList.add('selected');
      } else {
        el.classList.remove('selected');
      }
    });
  }
});


// Gestione rimozione immagine profilo utente
// (richiede una operation 'remove-image' lato server)
document.addEventListener('DOMContentLoaded', function(){
  var removeImageProfileBtn = document.getElementById('remove-image-profile-btn');
  if(removeImageProfileBtn){
    removeImageProfileBtn.addEventListener('click', function(e){
      e.preventDefault();
      if(!confirm('Sei sicuro di voler rimuovere la foto profilo?')) return;
      $.ajax({
        type: 'POST',
        url: 'user_operation.php',
        data: {
          operation: 'remove-image'
        },
        dataType: 'json',
      }).done(function(response){
        if(response.status == 'OK'){
          window.location.reload();
        }
        else if(response.status == 'SESSION_ERROR'){
          alert('Errore: ' + response.text_message);
        }
        else if(response.status == 'OPERATION_ERROR'){
          alert('Errore: ' + response.text_message);
        }
        else if(response.status == 'GENERIC_ERROR'){
          alert('Errore: ' + response.text_message);
        }
      });
    });
  }
});


document.addEventListener('DOMContentLoaded', function(){

  var removeImageProfileBtn = document.getElementById('remove-image-profile-btn');
  
  if(removeImageProfileBtn){
    removeImageProfileBtn.addEventListener('click', function(){

    



    });
  }

});

// Colora le palline colore nel carrello in base al value
// (classe .cart-color-box, colore preso da attribute value)
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.cart-color-box').forEach(function(el) {
    var colorName = el.getAttribute('value');
    if (colorName) {
      // Mappa nomi comuni se serve (opzionale)
      var colorMap = {
        'black': 'black',
        'white': 'white',
        'red': 'red',
        'blue': 'blue',
        'pink': 'pink',
        'yellow': 'yellow',
        'orange': 'orange',
        'green': 'green',
        'purple': 'purple',
        'brown': 'brown',
        'gray': 'gray',
        'beige': 'beige',
        // aggiungi altri se servono
      };
      var cssColor = colorMap[colorName.toLowerCase()] || colorName;
      el.style.backgroundColor = cssColor;
      el.style.display = 'inline-block';
      el.style.width = '22px';
      el.style.height = '22px';
      el.style.borderRadius = '50%';
      el.style.border = '1px solid #ccc';
      el.style.margin = '2px';
      el.style.verticalAlign = 'middle';
    }
  });
});