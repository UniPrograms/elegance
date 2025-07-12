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


//Costruisco dimaneticamente la barra di navigazione tra le pagine
$limit = 9; // Item che voglio vedere per ogni pagina (rimane costante)
$total_product = count($products); // Numero di prodotti totali
$page_needed =  ceil($total_product/$limit); // Numero di pagine necessarie

$current_page = isset($_REQUEST["page"]) ? ($_REQUEST["page"] != 0 ? $_REQUEST["page"] - 1 : 0) : 0;   // Pagina corrente con 0 come indice di partenza
$previous_page = $current_page == 0 ? $current_page  : $current_page - 1;
$next_page = $current_page == $page_needed ? $page_needed : $current_page + 1; 

$buffer = '';

// Qui dovrò fare in modo che non ci sia niente
if($page_needed == 1){ 
    $shop_pagination_page->setContent("pagination","");
}
// Qui dovrò avere [<][1][2][3][>]
else if($page_needed <= 3){
    $query_string_builder->add("page",$previous_page);
    $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'"><i class="fa fa-angle-left"></i></a></li>';

    for($i = 0; $i < $page_needed; $i++){
        $query_string_builder->add("page",$i);
        $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'">'.($i+1).'</a></li>';
    } 
        
    $query_string_builder->add("page",$next_page);
    $buffer .= '<li class="page-item"><a class="page-link" href="'.$query_string_builder->build().'"><i class="fa fa-angle-right"></i></a></li>';
    $shop_pagination_page->setContent("pagination",$buffer);
}
// Qui dovrò avere [<][1][2][3]...[max][>]
else if($current_page <= 2){
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';
    
    for($i = 0; $i < 3; $i++) 
        $buffer .= '<li class="page-item"><a class="page-link" href="#">'.($i+1).'</a></li>';
   
    $buffer .= '<li class="page-item"><a class="page-link" href="#">...</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">'.$page_needed.'</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
    $shop_pagination_page->setContent("pagination",$buffer);

}
// Qui dovrò avere [<][1]...[max-2][max-1][max][>]
else if($current_page >= $page_needed - 3){
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">1</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">...</a></li>';

    for($i = 2; $i >= 0; $i--) 
        $buffer .= '<li class="page-item"><a class="page-link" href="#">'.($page_needed - $i).'</a></li>';
    
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
    $shop_pagination_page->setContent("pagination",$buffer);
}
 // Qui dovrò avere [<][1]...[$current_page - 1][$current_page][$current_page + 1]...[max][>]
else if($current_page > 2 && $current_page < $page_needed - 2){
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">1</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">...</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">'.($current_page).'</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">'.($current_page+1).'</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">'.($current_page+2).'</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">...</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">'.$page_needed.'</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
    $shop_pagination_page->setContent("pagination",$buffer);
}


$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($isAjax) {
    echo $shop_pagination_page->get();
    exit;
}
