<?php

require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

$factory = new DataLayer(new DB_Connection());

$productDAO = $factory->getProductDAO();
$articleDAO = $factory->getArticleDAO();
$wishlistItemDAO = $factory->getWishlistItemDAO();



$article = $articleDAO->getArticleByProductSizeColor(1,1,1);

echo $wishlistItemDAO->itemIsContainted($article->getId(), 1) == 1;