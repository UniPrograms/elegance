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