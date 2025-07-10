<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");


// Componenti delle pagine
require("php/shop/shop_filter_menu.php");
require("php/shop/shop_product.php");
require("php/shop/shop_pagination.php");



// Template
$shop_page = new Template("skin/shop/shop.html");


$shop_page->setContent("shop_filter_menu",$shop_filter_menu_page->get());
$shop_page->setContent("shop_product",$shop_product_page->get());
$shop_page->setContent("shop_pagination",$shop_pagination_page->get());



