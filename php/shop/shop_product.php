<?php
// Template
$shop_product_page = new Template("skin/shop/shop_product.html");


// DAO
$factory = new DataLayer(new DB_Connection());
$productDAO = $factory->getProductDAO();


// Calcolo della paginazione
$current_page = isset($_REQUEST["page"]) ? $_REQUEST["page"] - 1 : 0; 
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



// Prendo i prodotti in base ai filtri passati
$products = $productDAO->getProductFiltered($name, $category_id, $sex_id, $color_id, $size_id, $productor_id, $min_price, $max_price, $limit, $offset);



?>