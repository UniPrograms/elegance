<?php
// Template
$shop_filter_menu_page = new Template("skin/shop/shop_filter_menu.html");

// DAO
$factory = new DataLayer(new DB_Connection());
$categoryDAO = $factory->getCategoryDAO();
$sexDAO = $factory->getSexDAO();
$productorDAO = $factory->getProductorDAO();
$colorDAO = $factory->getColorDAO();


// Setto le categorie (e il sesso) per il menu
foreach($sexDAO->getAllSexs() AS $sex){

    $shop_filter_menu_page->setContent("sex_name", $sex->getSex());
    $shop_filter_menu_page->setContent("sex_id", $sex->getId());
    $shop_filter_menu_page->setContent("data_target","#".$sex->getId());
    $shop_filter_menu_page->setContent("data_id", $sex->getId());

    foreach($categoryDAO->getAllCategories() as $category){
        $shop_filter_menu_page->setContent("category_id", $category->getId());
        $shop_filter_menu_page->setContent("category_name", $category->getName());
    }
}

// Setto i colori
foreach($colorDAO->getAllColors() as $color){
    $shop_filter_menu_page->setContent("color_value", $color->getId());
    $shop_filter_menu_page->setContent("color_name", $color->getColor());
}


// Setto il brand (produttore)
foreach($productorDAO->getAllProductores() as $productor){
    $shop_filter_menu_page->setContent("productor_value", $productor->getId());
    $shop_filter_menu_page->setContent("productor_name", $productor->getName());
}



?>