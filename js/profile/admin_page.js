// Ricerca ordine per ID (demo: cerca tra gli ordini fittizi visualizzati)
document.getElementById('search-order-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('search-order-id').value.trim();
    const orders = document.querySelectorAll('#sold-products-list .order-card');
    let found = false;
    orders.forEach((order, idx) => {
        // Per demo: l'ID "ordine" è l'indice+1 (es: 1, 2, ...)
        if (id === String(idx+1)) {
            found = true;
            const clone = order.cloneNode(true);
            const resultDiv = document.getElementById('order-details-result');
            resultDiv.innerHTML = '';
            resultDiv.appendChild(clone);
        }
    });
    if (!found) {
        document.getElementById('order-details-result').innerHTML = '<div style="color:#c00;">Ordine non trovato.</div>';
    }
});
// Ricerca ordine per ID (demo: cerca tra gli ordini fittizi visualizzati)
document.getElementById('search-order-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('search-order-id').value.trim();
    const orders = document.querySelectorAll('#sold-products-list .order-card');
    let found = false;
    orders.forEach((order, idx) => {
        // Per demo: l'ID "ordine" è l'indice+1 (es: 1, 2, ...)
        if (id === String(idx+1)) {
            found = true;
            const clone = order.cloneNode(true);
            const resultDiv = document.getElementById('order-details-result');
            resultDiv.innerHTML = '';
            resultDiv.appendChild(clone);
        }
    });
    if (!found) {
        document.getElementById('order-details-result').innerHTML = '<div style="color:#c00;">Ordine non trovato.</div>';
    }
});
// Gestione form aggiunta prodotto (solo demo, senza backend)
document.getElementById('add-product-form').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Prodotto aggiunto! (demo, nessun salvataggio reale)');
    this.reset();
});
