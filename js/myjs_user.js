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
          "item_id": itemId,
          "move": 1,
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

  // Selettore per tutti i bottoni "Rimuovi dalla wishlist"
  document.querySelectorAll('.remove-wishlist-item').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var itemId = this.getAttribute("value");

      $.ajax({
        type: "POST",
        url: "wishlist_operation.php",
        data: {
          "item_id": itemId,
          "delete": 1,
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
      fetch('cart_operation.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'delete=1&cart_item_id=' + encodeURIComponent(cartItemId)
      })
      .then(function(response) { return response.json(); })
      .then(function(data) {
        if (data.status === 'ERROR') {
          if (data.title_message && data.text_message) {
            alert(data.title_message + '\n' + data.text_message);
          } else {
            alert('Si è verificato un errore sconosciuto.');
          }
        } else if (data.status === 'OK') {
          // Aggiorna badge header
          var headerBadge = document.querySelector('#essenceCartBt span');
          if (headerBadge && data.counter !== undefined) {
            headerBadge.textContent = data.counter;
          }
          // Aggiorna numero articoli nella pagina carrello
          var cartTotal = document.querySelector('.cart-summary .list-group-item span');
          if (cartTotal && data.counter !== undefined) {
            cartTotal.textContent = data.counter;
          }
          // Aggiorna prezzo totale se presente nella risposta (opzionale)
          if (data.total_price !== undefined) {
            var priceSpan = document.querySelector('.cart-summary .font-weight-bold');
            if (priceSpan) priceSpan.textContent = data.total_price + ' $';
          }
          // Se il carrello è vuoto, reindirizza a cart.php
          if (data.counter == 0) {
            window.location.href = 'cart.php';
            return;
          }
          var row = btn.closest('tr');
          if (row) {
            row.style.transition = 'opacity 0.5s';
            row.style.opacity = 0;
            setTimeout(function() { row.remove(); }, 500);
          }
        } else {
          alert('Risposta inattesa dal server.');
        }
      })
      .catch(function() {
        alert('Si è verificato un errore di comunicazione con il server.');
      });
    });
  });
});



// Gestione apertura/chiusura menu categorie in base a category_id da URL
document.addEventListener('DOMContentLoaded', function() {
  // Funzione per ottenere il parametro category_id dalla query string
  function getCategoryIdFromUrl() {
    var params = new URLSearchParams(window.location.search);
    return params.get('category_id');
  }
  var categoryId = getCategoryIdFromUrl();
  // Seleziona tutti i link delle categorie principali (sesso)
  var sexLinks = document.querySelectorAll('.catagories-menu > ul > li > a[value]');
  sexLinks.forEach(function(link) {
    var value = link.getAttribute('value');
    var li = link.closest('li');
    var submenu = li ? li.querySelector('.sub-menu') : null;
    if (!categoryId) {
      // Nessun category_id: chiudi tutti i menu
      if (submenu) submenu.classList.remove('show');
    } else {
      // Se il value corrisponde al category_id, apri solo quel menu
      if (value === categoryId) {
        if (submenu) submenu.classList.add('show');
      } else {
        if (submenu) submenu.classList.remove('show');
      }
    }
  });
});
// Colora i quadrati dei colori nella shop sidebar in base all'attributo name
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.color_shop').forEach(function(el) {
    var colorName = el.getAttribute('name');
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
    }
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
      alert('Compila tutti i campi obbligatori.');
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
    // Anteprima avatar personal info
    const upload = document.getElementById('ct-profile-upload');
    const preview = document.getElementById('ct-profile-img-preview');
    if(upload && preview) {
        upload.addEventListener('change', function(e) {
            if (upload.files && upload.files[0]) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    preview.src = ev.target.result;
                };
                reader.readAsDataURL(upload.files[0]);
            }
        });
    }
// Gestione submit form prodotto
// Sostituisce la versione precedente: aggancio tramite id

document.addEventListener('DOMContentLoaded', function() {
  var productForm = document.getElementById('add-to-cart-form');
  if (!productForm) return;
  productForm.addEventListener('submit', function(e) {
    e.preventDefault();
    // id prodotto (campo nascosto)
    var productId = productForm.querySelector('input[name="product_id"]')?.value;
    // id size selezionata (select)
    var sizeInput = productForm.querySelector('select[name="size_id"]');
    var sizeId = sizeInput ? sizeInput.value : '';
    // colore selezionato (select)
    var colorInput = productForm.querySelector('select[name="color_id"]');
    var colorId = colorInput ? colorInput.value : '';
    
    $.ajax({
      type: "POST",
      url:"cart_operation.php",
      data:{
        "store": 1,
        "product_id": productId,
        "size_id": sizeId,
        "color_id": colorId,
      },
      dataType: "json",
    }).done(function(response){

      if(response.status == "OK"){
        var cart_size = response.cart_item_size;
        var article_qty = response.article_qty;

        // Aggiorno il badge del carrello nell'header
        var headerBadge = document.querySelector('#essenceCartBt span');
        if(headerBadge && typeof cart_size !== "undefined"){
          headerBadge.textContent = cart_size;
        }

        // Aggiorno la quantità dell'oggetto
        var labelAvailable = document.querySelector('#available-label');
        if(labelAvailable && typeof article_qty !== "undefined"){
          if(article_qty <= 0){
            labelAvailable.setAttribute("class","alert alert-danger font-weight-bold product-ended-alert");
          }
        }
      }
      else{
        alert("Errore: " + response.text_message);
      }

    });

  });
});