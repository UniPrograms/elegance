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
document.addEventListener('DOMContentLoaded', function() {

    // Rimozione dalla wishlist
    document.querySelectorAll('.wishlist-remove-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var itemId = link.getAttribute('value');
            if (!itemId) return;
            var params = new URLSearchParams();
            params.append('delete', '1');
            params.append('item_id', itemId);

            fetch('wishlist_operation.php', {
                method: 'POST',
                body: params
            })
            .then(response => response.text())
            .then(function(text) {
                if (text.trim() === 'OK') {
                    var card = link.closest('.wishlist-product-card');
                    if (card) {
                        card.style.transition = 'opacity 0.5s';
                        card.style.opacity = '0';
                        setTimeout(function() { card.remove(); }, 500);
                    }
                } else {
                    alert('Impossibile rimuovere l\'oggetto dalla wishlist.');
                }
            })
            .catch(function() {
                alert('Errore di comunicazione con il server.');
            });
        });
    });

    // Spostamento al carrello
    document.querySelectorAll('.wishlist-add-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var itemId = btn.getAttribute('value');
            if (!itemId) return;
            var params = new URLSearchParams();
            params.append('move', '1');
            params.append('item_id', itemId);

            fetch('wishlist_operation.php', {
                method: 'POST',
                body: params
            })
            .then(response => response.text())
            .then(function(text) {
                if (text.trim() === 'OK') {
                    var card = btn.closest('.wishlist-product-card');
                    if (card) {
                        card.style.transition = 'opacity 0.5s';
                        card.style.opacity = '0';
                        setTimeout(function() { card.remove(); }, 500);
                    }
                } else {
                    alert('Impossibile spostare l\'oggetto nel carrello.');
                }
            })
            .catch(function() {
                alert('Errore di comunicazione con il server.');
            });
        });
    });
});