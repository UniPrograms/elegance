<?php

require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");

$factory = new DataLayer(new DB_Connection());


$cartDAO = $factory->getCartDAO();
$cart = $cartDAO->getCartByUserId(1);

echo $cart == null ? "sono null" : "non sono null";

/*
// Utente 
$user = $factory->getUserDAO()->getUserById(1);
echo ("<h2> Utente: " . $user->getName() . "</h2>");
echo ("<h2> Utente ID: " . $user->getId() . "</h2>");

// Spedizione
$delivery = $factory->getDeliveryDAO()->getDeliveryById(2);
echo ("<h2> Spedizione: " . $delivery->getName() . "</h2>");

$pagamento = $factory->getPaymentDAO()->getPaymentById(1);
echo ("<h2> Pagamento: " . $pagamento->getName() . "</h2>");

// Produttore
$produttore = $factory->getProductorDAO()->getProductorById(1);
echo ("<h2> Produttore: " . $produttore->getName() . "</h2>");

// Categoria
$categoria = $factory->getCategoryDAO()->getCategoryById(1);
echo ("<h2> Categoria: " . $categoria->getName() . "</h2>");

// Sesso
$sesso = $factory->getSexDAO()->getSexById(1);
echo ("<h2> Sesso: " . $sesso->getSex() . "</h2>");

// Sesso
$taglia = $factory->getSizeDAO()->getSizeById(1);
echo ("<h2> Sesso: " . $taglia->getSize() . "</h2>");

// Prodotto
$prodotto = $factory->getProductDAO()->getProductById(1);
echo ("<h2> Prodotto: " . $prodotto->getName() . "</h2>");
echo ("<h2> Produttore del prodotto: " . $prodotto->getProductor()->getName() . "</h2>");
echo ("<h2> Sesso del prodotto: " . $prodotto->getSex()->getSex() . "</h2>");
echo ("<h2> Categoria del prodotto: " . $prodotto->getCategory()->getName() . "</h2>");
echo ("<h2> Path immagine 1 del prodotto: " . $prodotto->getImages()[0]->getPath(). "</h2>");
echo ("<h2> Path immagine 2 del prodotto: " . $prodotto->getImages()[1]->getPath(). "</h2>");

// Colore
$colore = $factory->getColorDAO()->getColorById(1);
echo ("<h2> Colore: " . $colore->getColor() . "</h2>");

// Articolo
$articolo = $factory->getArticleDAO()->getArticleById(1);
echo ("<h2> Articolo: " . $articolo->getProduct()->getName() . "</h2>");
echo ("<h2> Quantità articolo: " . $articolo->getQuantity() . "</h2>");

// Caratteristica
$caratteristica = $factory->getFeatureDAO()->getFeatureById(1);
echo ("<h2> Caratteristica: " . $caratteristica->getName() . "</h2>");

// Caratteristica Prodotto
$caratteristica_prodotto = $factory->getproductFeatureDAO()->getProductFeatureById(1);
echo ("<h2> Caratteristica prodotto 1: " . $caratteristica_prodotto->getFeature()->getName() . "</h2>");
echo ("<h2> Caratteristica prodotto 1 testo: " . $caratteristica_prodotto->getDescription() . "</h2>");

// Carrello
$carrello = $factory->getCartDAO()->getCartByUser($user);
echo ("<h2> Carrello n. : " . $carrello->getId() . "</h2>");
echo ("<h2> Articolo in carrello : " . $carrello->getCartItem()[0]->getArticle()->getProduct()->getName() . "</h2>");

// Wishlist
$lista_desideri = $factory->getWishlistDAO()->getWishlistByUser($user);
echo ("<h2> Lista Desideri n. : " . $lista_desideri->getId() . "</h2>");
echo ("<h2> Articolo in lista desideri : " . $lista_desideri->getWishlistItem()[0]->getArticle()->getProduct()->getName() . "</h2>");

// Notifica
// Non è possibile testare la notifica

// Ordine
$ordine = $factory->getOrderDAO()->getOrderById(1);
echo ("<h2> Ordine n. : " . $ordine->getOrderDate() . "</h2>");
echo ("<h2> Articolo in ordine : " . $ordine->getOrderItem()[0]->getArticle()->getProduct()->getName() . "</h2>");


// Recensione
$recensione = $factory->getReviewDAO()->getReviewByProduct($prodotto);
echo ("<h2> Recensione: " . $recensione[0]->getText() . "</h2>");


// Valutazione
$valutazione = $factory->getEvaluationDAO()->getEvaluationByProduct($prodotto);
echo ("<h2> Valutazione: " . $valutazione[0]->getStar() . "</h2>");



*/