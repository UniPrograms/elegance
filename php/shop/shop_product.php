<?php
// Template
$shop_product_page = new Template("skin/shop/shop_product.html");


// DAO
$factory = new DataLayer(new DB_Connection());
$productDAO = $factory->getProductDAO();


// Calcolo della paginazione
$current_page = isset($_REQUEST["page"]) && $_REQUEST["page"] > 0 ? $_REQUEST["page"] : 0;
$limit = 9; // Item che voglio vedere per ogni pagina (rimane costante)
$offset = $current_page * $limit; // Da che punto partire con la paginazione


// Controllo i filtri che sono stati passati
$name = isset($_GET["name"]) ? $_GET["name"] : null;
$category_id = isset($_GET["category_id"]) ? (int) $_GET["category_id"] : null;
$sex_id = isset($_GET["sex_id"]) ? (int) $_GET["sex_id"] : null;
$size_id = isset($_GET["size_id"]) ? (int) $_GET["size_id"] : null;
$productor_id = isset($_GET["productor_id"]) ? (int) $_GET["productor_id"] : null;
$color_id = isset($_GET["color_id"]) ? (int) $_GET["color_id"] : null;
$min_price = isset($_GET["min_price"]) ? (float) $_GET["min_price"] : null;
$max_price = isset($_GET["max_price"]) ? (float) $_GET["max_price"] : null;


// Inserisco il numero di prodotti totali trovati nella pagina
$products = $productDAO->getProductFiltered($name, $category_id, $sex_id, $color_id, $size_id, $productor_id, $min_price, $max_price);
$shop_product_page->setContent("counter_products_found", count($products));



// Prendo i prodotti paginati in base ai filtri passati
$paginatedproducts = $productDAO->getProductFiltered($name, $category_id, $sex_id, $color_id, $size_id, $productor_id, $min_price, $max_price, $limit, $offset);


$buffer = "";
foreach ($paginatedproducts as $product) {

    $query_string_builder = new QueryStringBuilder("product.php");
    $query_string_builder->add("product_id",$product->getId());

    $buffer .= '<div class="col-12 col-sm-6 col-lg-4">';
    $buffer .= '<div class="single-product-wrapper">';
    $buffer .= '<div class="product-img">';
    $buffer .= '<img src="'.$product->getCopertina().'" alt="" />';
    $buffer .= '<img class="hover-img" src="'.$product->getCopertina().'" alt="" />';
    $buffer .= '</div>';
    $buffer .= '<div class="product-description">';
    $buffer .= '<span>'.$product->getProductor()->getName().'</span>';
    $buffer .= '<a href="'.$query_string_builder->build().'">';
    $buffer .= '<h6>'.$product->getName().'</h6>';
    $buffer .= '</a>';
    $buffer .= '<p class="product-price">'.$product->getPrice().' $</p>';
    $buffer .= '<div class="hover-content">';
    $buffer .= '<div class="add-to-cart-btn">';
    $query_string_builder->refresh("product.php");
    $query_string_builder->add("product_id", $product->getId());
    $buffer .= '<a href="'.$query_string_builder->build().'" class="btn essence-btn">View Product</a>';
    $buffer .= '</div>';
    $buffer .= '</div>';
    $buffer .= '</div>';
    $buffer .= '</div>';
    $buffer .= '</div>';
}

$shop_product_page->setContent("products_item",$buffer);

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($isAjax) {
    $ajax_response = new AjaxResponse("OK");
    $ajax_response->add("counter_products_found", count($products));
    $ajax_response->add("content",$shop_product_page->get());
    echo $ajax_response->build();
    exit;
}
