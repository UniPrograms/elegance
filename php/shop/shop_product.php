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

$name = isset($_REQUEST["name"]) && !empty($_REQUEST["name"])? $_REQUEST["name"] : null;

$category_id = isset($_REQUEST["category_id"]) && $_REQUEST["category_id"] > 0 ? (int) $_REQUEST["category_id"] : null;

$sex_id = isset($_REQUEST["sex_id"]) && $_REQUEST["sex_id"] > 0 ? (int) $_REQUEST["sex_id"] : null;

$size_id = isset($_REQUEST["size_id"]) && $_REQUEST["size_id"] > 0 ? (int) $_REQUEST["size_id"] : null;

$productor_id = isset($_REQUEST["productor_id"]) && $_REQUEST["productor_id"] > 0 ? (int) $_REQUEST["productor_id"] : null;

$color_id = isset($_REQUEST["color_id"]) && $_REQUEST["color_id"] > 0 ? $_REQUEST["color_id"] : null;

$min_price = isset($_REQUEST["min_price"]) ? (float) $_REQUEST["min_price"] : null;

$max_price = isset($_REQUEST["max_price"]) ? (float) $_REQUEST["max_price"] : null;


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
