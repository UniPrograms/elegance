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
    $shop_filter_menu_page->setContent("sex_value", $sex->getId());

    $query_string_builder = new QueryStringBuilder("shop.php");
    $query_string_builder->add("sex_id", $sex->getId());
    $shop_filter_menu_page->setContent("category_all_link",$query_string_builder->build());
   
    foreach($categoryDAO->getAllCategories() as $category){
        $shop_filter_menu_page->setContent("category_value", $category->getId());
        $shop_filter_menu_page->setContent("category_name", $category->getName());

        // Link della categoria e del sesso
        $query_string_builder = new QueryStringBuilder("shop.php");
        $query_string_builder->add("sex_id", $sex->getId());
        $query_string_builder->add("category_id", $category->getId());
        $shop_filter_menu_page->setContent("category_link",$query_string_builder->build());
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