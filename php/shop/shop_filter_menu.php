<?php
// Template
$shop_filter_menu_page = new Template("skin/shop/shop_filter_menu.html");

// DAO
$factory = new DataLayer(new DB_Connection());
$productDAO = $factory->getProductDAO();
$categoryDAO = $factory->getCategoryDAO();
$sexDAO = $factory->getSexDAO();
$productorDAO = $factory->getProductorDAO();
$colorDAO = $factory->getColorDAO();


// Controllo se è stato inserito un nome di un prodotto
if(isset($_REQUEST["name"]) && !empty($_REQUEST["name"])){
    $shop_filter_menu_page->setContent("product_name", $_REQUEST["name"]);
}

// Setto le categorie (e il sesso) per il menu
foreach($sexDAO->getAllSexs() AS $sex){
    $shop_filter_menu_page->setContent("sex_name", $sex->getSex());
    $shop_filter_menu_page->setContent("sex_value", $sex->getId());

    // Lo pre-imposto se era stato selezionato nella pagina precedente
    if(isset($_REQUEST["sex_id"]) && $_REQUEST["sex_id"] > 0 && $_REQUEST["sex_id"] == $sex->getId()){
        $shop_filter_menu_page->setContent("sex_selected","selected");
    }
    else{
        $shop_filter_menu_page->setContent("sex_selected", "");
    }
   
   
}

// Setto le cateorie
foreach($categoryDAO->getAllCategories() as $category){
    $shop_filter_menu_page->setContent("category_value", $category->getId());
    $shop_filter_menu_page->setContent("category_name", $category->getName());

    // Lo pre-imposto se era stato selezionato nella pagina precedente
    if(isset($_REQUEST["category_id"]) && $_REQUEST["category_id"] > 0 && $_REQUEST["category_id"] == $category->getId()){
        $shop_filter_menu_page->setContent("category_selected","selected");
    }
    else{
        $shop_filter_menu_page->setContent("category_selected", "");
    }

}

// Setto il brand (produttore)
foreach($productorDAO->getAllProductores() as $productor){
    $shop_filter_menu_page->setContent("productor_value", $productor->getId());
    $shop_filter_menu_page->setContent("productor_name", $productor->getName());

    // Lo pre-imposto se era stato selezionato nella pagina precedente
    if(isset($_REQUEST["productor_id"]) && $_REQUEST["productor_id"] > 0 && $_REQUEST["productor_id"] == $productor->getId()){
        $shop_filter_menu_page->setContent("productor_selected","selected");
    }
    else{
        $shop_filter_menu_page->setContent("productor_selected", "");
    }

}

// Setto i colori
foreach($colorDAO->getAllColors() as $color){
    $shop_filter_menu_page->setContent("color_value", $color->getId());
    $shop_filter_menu_page->setContent("color_name", $color->getColor());

    // Lo pre-imposto se era stato selezionato nella pagina precedente
    if(isset($_REQUEST["color_id"]) && $_REQUEST["color_id"] > 0 && $_REQUEST["color_id"] == $color->getId()){
        $shop_filter_menu_page->setContent("color_selected","selected");
    }
    else{
        $shop_filter_menu_page->setContent("color_selected", "");
    }
}


// Setto il prezzo minimo
$min_price = 0;
$max_price = intval(ceil($productDAO->getMaxProductPrice() / 100) * 100);
$shop_filter_menu_page->setContent("min_price_bound", $min_price);
$shop_filter_menu_page->setContent("max_price_bound", $max_price);



// pre-setto il valore del prezzo corrente
if(!isset($_REQUEST["min_price"])){
    $shop_filter_menu_page->setContent("min_price_value", $min_price);
}else{
    $shop_filter_menu_page->setContent("min_price_value", $_REQUEST["min_price"]);
}

// Setto il prezzo massimo e pre-setto il valore corrente
if(!isset($_REQUEST["max_price"])){
    $shop_filter_menu_page->setContent("max_price_value", $max_price);
}
else{
    $shop_filter_menu_page->setContent("max_price_value", $_REQUEST["max_price"]);
}


?>