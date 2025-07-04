// Mostra/nascondi form cambio password
if (document.getElementById('change-password-btn')) {
    document.getElementById('change-password-btn').addEventListener('click', function(e) {
        e.preventDefault();
        var form = document.getElementById('change-password-form-container');
        form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
    });
}
// (Opzionale) Validazione base lato client
if (document.getElementById('change-password-form')) {
    document.getElementById('change-password-form').addEventListener('submit', function(e) {
        var newPass = document.getElementById('new-password').value;
        var confirmPass = document.getElementById('confirm-password').value;
        if(newPass !== confirmPass) {
            alert('Le nuove password non coincidono.');
            e.preventDefault();
        }
    });
}
// PAGINAZIONE ORDINI
if (document.getElementById('orders-list')) {
    document.addEventListener('DOMContentLoaded', function() {
        const ordersPerPage = 8;
        const ordersList = document.getElementById('orders-list');
        const allOrders = Array.from(ordersList.getElementsByClassName('order-card'));
        const pagination = document.getElementById('pagination');
        let currentPage = 1;
        const totalPages = Math.ceil(allOrders.length / ordersPerPage);

        function showPage(page) {
            allOrders.forEach((order, idx) => {
                order.style.display = (idx >= (page-1)*ordersPerPage && idx < page*ordersPerPage) ? '' : 'none';
            });
            renderPagination(page);
        }

        function renderPagination(page) {
            let html = '';
            const btnStyle = "font-size:12px;padding:3px 10px;min-width:28px;height:28px;line-height:1.1;margin:0 2px;";
            if (totalPages > 1) {
                if(page > 1) html += `<button class='btn essence-btn' style='${btnStyle}margin-right:6px;' onclick='goToPage(${page-1})'>&laquo;</button>`;
                for(let i=1; i<=totalPages; i++) {
                    html += `<button class='btn essence-btn${i===page?' active':''}' style='${btnStyle}' onclick='goToPage(${i})'>${i}</button>`;
                }
                if(page < totalPages) html += `<button class='btn essence-btn' style='${btnStyle}margin-left:6px;' onclick='goToPage(${page+1})'>&raquo;</button>`;
            }
            pagination.innerHTML = html;
        }

        window.goToPage = function(page) {
            currentPage = page;
            showPage(page);
        }

        showPage(currentPage);
    });
}
// Click icona matita = apri file picker
if (document.getElementById('edit-profile-pic')) {
    document.getElementById('edit-profile-pic').addEventListener('click', function() {
        document.getElementById('profile-upload').click();
    });
}
// Anteprima immagine profilo lato client
if (document.getElementById('profile-upload')) {
    document.getElementById('profile-upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('profile-img').src = ev.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
}
