<?php

require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

$factory = new DataLayer(new DB_Connection());

$cartDAO = $factory->getCartDAO();

$wishlistDAO = $factory->getWishlistDAO();

$wishlist = $wishlistDAO->getWishlistById(1);

echo $wishlist == null ? "è null" : "non è null";
echo $wishlist->getSize();