<?php
// Template
$shop_pagination_page = new Template("skin/shop/shop_pagination.html");


// DAO
$factory = new DataLayer(new DB_Connection());
$productDAO = $factory->getProductDAO();


// Calcolo della paginazione
$current_page = isset($_REQUEST["page"]) ? $_REQUEST["page"] - 1 : 0;
$limit = 9; // Item che voglio vedere per ogni pagina (rimane costante)




// Controllo i filtri che sono stati passati
$name = isset($_GET["name"]) ? $_GET["name"] : null;
$category_id = isset($_GET["category_id"]) ? (int) $_GET["category_id"] : null;
$sex_id = isset($_GET["sex_id"]) ? (int) $_GET["sex_id"] : null;
$size_id = isset($_GET["size_id"]) ? (int) $_GET["size_id"] : null;
$productor_id = isset($_GET["productor_id"]) ? (int) $_GET["productor_id"] : null;
$color_id = isset($_GET["color_id"]) ? (int) $_GET["color_id"] : null;
$min_price = isset($_GET["min_price"]) ? (float) $_GET["min_price"] : null;
$max_price = isset($_GET["max_price"]) ? (float) $_GET["max_price"] : null;


// Prendo i prodotti in base ai filtri passati
$products = $productDAO->getProductFiltered($name, $category_id, $sex_id, $color_id, $size_id, $productor_id, $min_price, $max_price);


// Costruisco dimaneticamente la barra di navigazione tra le pagine
//$total_product = count($products); 
//$page_needed =  ceil($total_product/$limit);
$total_product = 72; 
$page_needed =  ceil($total_product/$limit);


$buffer = '';

// Qui dovrò fare in modo che non ci sia niente
if($page_needed == 1){ 
    
    $shop_pagination_page->setContent("pagination","");

}
// Qui dovrò avere [<][1][2][3][>]
else if($page_needed <= 3){
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';

    for($i = 0; $i < $page_needed; $i++) 
        $buffer .= '<li class="page-item"><a class="page-link" href="#">'.($i+1).'</a></li>';
    
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
    $shop_pagination_page->setContent("pagination",$buffer);
}
// Qui dovrò avere [<][1][2][3]...[max][>]
else if($current_page <= 3){
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';
    
    for($i = 0; $i < 3; $i++) 
        $buffer .= '<li class="page-item"><a class="page-link" href="#">'.($i+1).'</a></li>';
   
    $buffer .= '<li class="page-item"><a class="page-link" href="#">...</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">'.$page_needed.'</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
    $shop_pagination_page->setContent("pagination",$buffer);

}
// Qui dovrò avere [<][1]...[max-2][max-1][max][>]
else if($current_page >= $page_needed - 2){
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">1</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">...</a></li>';

    for($i = 2; $i >= 0; $i--) 
        $buffer .= '<li class="page-item"><a class="page-link" href="#">'.($page_needed - $i).'</a></li>';
    
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
    $shop_pagination_page->setContent("pagination",$buffer);
}
 // Qui dovrò avere [<][1]...[$current_page - 1][$current_page][$current_page + 1]...[max][>]
else if($current_page > 3 && $current_page < $page_needed - 2){
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">1</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">...</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">'.($current_page-1).'</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">'.$current_page.'</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">'.($current_page+1).'</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">...</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#">'.$page_needed.'</a></li>';
    $buffer .= '<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
    $shop_pagination_page->setContent("pagination",$buffer);
}

/*
if(pagina_richiamata_da_ajax){
    echo $shop_pagination_page->get();
}
*/


/*  
<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>
<li class="page-item"><a class="page-link" href="#">1</a></li>
<li class="page-item"><a class="page-link" href="#">2</a></li>
<li class="page-item"><a class="page-link" href="#">3</a></li>
<li class="page-item"><a class="page-link" href="#">...</a></li>
<li class="page-item"><a class="page-link" href="#">21</a></li>
<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>
*/