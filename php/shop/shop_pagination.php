<?php
// Template
$shop_pagination_page = new Template("skin/shop/shop_pagination.html");


// DAO
$factory = new DataLayer(new DB_Connection());
$productDAO = $factory->getProductDAO();


// Calcolo della paginazione





// Controllo i filtri che sono stati passati
$name = isset($_GET["name"]) ? $_GET["name"] : null;
$category_id = isset($_GET["category_id"]) ? (int) $_GET["category_id"] : null;
$sex_id = isset($_GET["sex_id"]) ? (int) $_GET["sex_id"] : null;
$size_id = isset($_GET["size_id"]) ? (int) $_GET["size_id"] : null;
$productor_id = isset($_GET["productor_id"]) ? (int) $_GET["productor_id"] : null;
$color_id = isset($_GET["color_id"]) ? (int) $_GET["color_id"] : null;
$min_price = isset($_GET["min_price"]) ? (float) $_GET["min_price"] : null;
$max_price = isset($_GET["max_price"]) ? (float) $_GET["max_price"] : null;


// Costruisco la query string in base ai valori forniti
$query_string_builder = new QueryStringBuilder("shop.php");
if(isset($_GET["name"])) $query_string_builder->add("name", $_GET["name"]);
if(isset($_GET["category_id"])) $query_string_builder->add("category_id", $_GET["category_id"]);
if(isset($_GET["sex_id"])) $query_string_builder->add("sex_id", $_GET["sex_id"]);
if(isset($_GET["size_id"])) $query_string_builder->add("size_id", $_GET["size_id"]);
if(isset($_GET["productor_id"])) $query_string_builder->add("productor_id", $_GET["productor_id"]);
if(isset($_GET["color_id"])) $query_string_builder->add("color_id", $_GET["color_id"]);
if(isset($_GET["min_price"])) $query_string_builder->add("min_price", $_GET["min_price"]);
if(isset($_GET["max_price"])) $query_string_builder->add("max_price", $_GET["max_price"]);



// Prendo TUTTI i prodotti in base ai filtri passati (Non passo limit e offset)
$products = $productDAO->getProductFiltered($name, $category_id, $sex_id, $color_id, $size_id, $productor_id, $min_price, $max_price);


//Costruisco dinamicamente la barra di navigazione tra le pagine
$limit = 9; // Item che voglio vedere per ogni pagina (rimane costante)
$total_product = count($products); // Numero di prodotti totali
$total_pages = ceil($total_product / $limit); // Numero di pagine necessarie

// Pagina corrente (0-based per il sistema, ma 1-based per la visualizzazione)
$current_page = isset($_GET["page"]) ? max(0, (int)$_GET["page"]) : 0;
$current_page_display = $current_page + 1; // Per la visualizzazione (1-based)

$buffer = '';

// Se c'è solo una pagina o nessun prodotto, non mostrare la paginazione
if($total_pages <= 1){ 
    $shop_pagination_page->setContent("pagination", "");
}
// Se ci sono 3 o meno pagine, mostra tutte le pagine
else if($total_pages <= 3){
    // Link pagina precedente
    if($current_page > 0) {
        $query_string_builder->add("page", $current_page - 1);
        $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'"><i class="fa fa-angle-left"></i></a></li>';
    } else {
        $buffer .= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';
    }

    // Numeri delle pagine
    for($i = 0; $i < $total_pages; $i++){
        $query_string_builder->add("page", $i);
        $active_class = ($i == $current_page) ? ' active' : '';
        $buffer .= '<li class="page-item'.$active_class.'"><a class="page-link" href="'.$query_string_builder->build().'">'.($i+1).'</a></li>';
    } 
        
    // Link pagina successiva
    if($current_page < $total_pages - 1) {
        $query_string_builder->add("page", $current_page + 1);
        $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'"><i class="fa fa-angle-right"></i></a></li>';
    } else {
        $buffer .= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
    }
    
    $shop_pagination_page->setContent("pagination", $buffer);
}
// Se siamo nelle prime 3 pagine
else if($current_page <= 2){
    // Link pagina precedente
    if($current_page > 0) {
        $query_string_builder->add("page", $current_page - 1);
        $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'"><i class="fa fa-angle-left"></i></a></li>';
    } else {
        $buffer .= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';
    }
    
    // Prime 3 pagine
    for($i = 0; $i < 3; $i++) {
        $query_string_builder->add("page", $i);
        $active_class = ($i == $current_page) ? ' active' : '';
        $buffer .= '<li class="page-item'.$active_class.'"><a class="page-link" href="'.$query_string_builder->build().'">'.($i+1).'</a></li>';
    }
   
    $buffer .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
    
    // Ultima pagina
    $query_string_builder->add("page", $total_pages - 1);
    $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'">'.$total_pages.'</a></li>';
    
    // Link pagina successiva
    $query_string_builder->add("page", $current_page + 1);
    $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'"><i class="fa fa-angle-right"></i></a></li>';
    
    $shop_pagination_page->setContent("pagination", $buffer);
}
// Se siamo nelle ultime 3 pagine
else if($current_page >= $total_pages - 3){
    // Link pagina precedente
    $query_string_builder->add("page", $current_page - 1);
    $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'"><i class="fa fa-angle-left"></i></a></li>';
    
    // Prima pagina
    $query_string_builder->add("page", 0);
    $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'">1</a></li>';
    
    $buffer .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';

    // Ultime 3 pagine
    for($i = $total_pages - 3; $i < $total_pages; $i++) {
        $query_string_builder->add("page", $i);
        $active_class = ($i == $current_page) ? ' active' : '';
        $buffer .= '<li class="page-item'.$active_class.'"><a class="page-link" href="'.$query_string_builder->build().'">'.($i+1).'</a></li>';
    }
    
    // Link pagina successiva
    if($current_page < $total_pages - 1) {
        $query_string_builder->add("page", $current_page + 1);
        $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'"><i class="fa fa-angle-right"></i></a></li>';
    } else {
        $buffer .= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
    }
    
    $shop_pagination_page->setContent("pagination", $buffer);
}
// Se siamo nel mezzo (caso generale)
else {
    // Link pagina precedente
    $query_string_builder->add("page", $current_page - 1);
    $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'"><i class="fa fa-angle-left"></i></a></li>';
    
    // Prima pagina
    $query_string_builder->add("page", 0);
    $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'">1</a></li>';
    
    $buffer .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
    
    // Pagina corrente e adiacenti
    for($i = $current_page - 1; $i <= $current_page + 1; $i++) {
        $query_string_builder->add("page", $i);
        $active_class = ($i == $current_page) ? ' active' : '';
        $buffer .= '<li class="page-item'.$active_class.'"><a class="page-link" href="'.$query_string_builder->build().'">'.($i+1).'</a></li>';
    }
    
    $buffer .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
    
    // Ultima pagina
    $query_string_builder->add("page", $total_pages - 1);
    $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'">'.$total_pages.'</a></li>';
    
    // Link pagina successiva
    $query_string_builder->add("page", $current_page + 1);
    $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'"><i class="fa fa-angle-right"></i></a></li>';
    
    $shop_pagination_page->setContent("pagination", $buffer);
}


$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($isAjax) {
    $ajax_response = new AjaxResponse("OK");
    $ajax_response->add("content",$shop_pagination_page->get());
    echo $ajax_response->build();
    exit;
}


