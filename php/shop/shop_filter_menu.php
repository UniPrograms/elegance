<?php
// Template
$shop_filter_menu_page = new Template("skin/shop/shop_filter_menu.html");

// DAO
$factory = new DataLayer(new DB_Connection());
$categoryDAO = $factory->getCategoryDAO();
$sexDAO = $factory->getSexDAO();
$productorDAO = $factory->getProductorDAO();
$colorDAO = $factory->getColorDAO();

// Sesso
$shop_filter_menu_page->setContent("foreach_sex", function() use ($sexDAO) {
    $buffer = '';
    foreach($sexDAO->getAllSexs() as $sex) {
        $buffer .= '<[sex_value]>' . $sex->getId() . '<[/sex_value]>';
        $buffer .= '<[sex_name]>' . htmlspecialchars($sex->getSex()) . '<[/sex_name]>';
    }
    return $buffer;
});

// Categoria
$shop_filter_menu_page->setContent("foreach_category", function() use ($categoryDAO) {
    $buffer = '';
    foreach($categoryDAO->getAllCategories() as $category) {
        $buffer .= '<[category_value]>' . $category->getId() . '<[/category_value]>';
        $buffer .= '<[category_name]>' . htmlspecialchars($category->getName()) . '<[/category_name]>';
    }
    return $buffer;
});

// Brand
$shop_filter_menu_page->setContent("foreach_productor", function() use ($productorDAO) {
    $buffer = '';
    foreach($productorDAO->getAllProductores() as $productor) {
        $buffer .= '<[productor_value]>' . $productor->getId() . '<[/productor_value]>';
        $buffer .= '<[productor_name]>' . htmlspecialchars($productor->getName()) . '<[/productor_name]>';
    }
    return $buffer;
});

// Colori
$shop_filter_menu_page->setContent("foreach_color", function() use ($colorDAO) {
    $buffer = '';
    foreach($colorDAO->getAllColors() as $color) {
        $buffer .= '<[color_value]>' . $color->getId() . '<[/color_value]>';
        $buffer .= '<[color_name]>' . htmlspecialchars($color->getColor()) . '<[/color_name]>';
    }
    return $buffer;
});

?>