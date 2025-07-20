<?php
// DATABASE
require_once("include/db/DB_Connection.php");
require_once("include/db/DataLayer.php");
require_once("include/utility/QueryStringBuilder.php");



if(!isset($_SESSION["auth"])){
    // Si rimanda ad una nuova pagina di errore
}

// Template
$admin_viewproduct_page = new Template("skin/admin_profile/admin_viewproduct.html");

//DAO
$factory = new DataLayer(new DB_Connection);
$productDAO = $factory->getProductDAO();
$categoryDAO = $factory->getCategoryDAO();
$sexDAO = $factory->getSexDAO();
$productorDAO = $factory->getProductorDAO();
$imageDAO = $factory->getImageDAO();

// Se il prodotto è stato passato, allora inizializzo i dati del prodotto
if(isset($_REQUEST["product_id"])){
    // Dati specifici del prodotto
    $product = $productDAO->getProductById((int)$_REQUEST["product_id"]);
    $admin_viewproduct_page->setContent("product_id", $product->getId());
    $admin_viewproduct_page->setContent("product_name", $product->getName());
    $admin_viewproduct_page->setContent("product_brand", $product->getProductor()->getName());
    $admin_viewproduct_page->setContent("product_price", $product->getPrice());
    $admin_viewproduct_page->setContent("product_description", $product->getDescription());
    $admin_viewproduct_page->setContent("product_copertina", $product->getCopertina());

    // Titolo della pagina
    $admin_viewproduct_page->setContent("product_title", "product:");

    // Valore del prodotto per andare nella pagina degli articoli
    $admin_viewproduct_page->setContent("product_value", $product->getId());
}else{
    // Titolo della pagina
    $admin_viewproduct_page->setContent("product_title", "new product");
    // Valore del prodotto per andare nella pagina degli articoli
    $admin_viewproduct_page->setContent("product_value", "");
}

// Inizializzo le categorie
foreach($categoryDAO->getAllCategories() as $category){
    $admin_viewproduct_page->setContent("category_id", $category->getId());
    $admin_viewproduct_page->setContent("category_name", $category->getName());
    
    // Seleziona automaticamente la categoria corrente del prodotto
    if(isset($product) && $category->getId() == $product->getCategory()->getId()){
        $admin_viewproduct_page->setContent("category_selected", "selected");
    } else {
        $admin_viewproduct_page->setContent("category_selected", "");
    }
}

// Inizializzo i sessi
foreach($sexDAO->getAllSexs() as $sex){
    $admin_viewproduct_page->setContent("sex_id", $sex->getId());
    $admin_viewproduct_page->setContent("sex_name", $sex->getSex());
    
    // Seleziona automaticamente il sesso corrente del prodotto
    if(isset($product) && $sex->getId() == $product->getSex()->getId()){
        $admin_viewproduct_page->setContent("sex_selected", "selected");
    } else {
        $admin_viewproduct_page->setContent("sex_selected", "");
    }
}

// Inizializzo i produttori
foreach($productorDAO->getAllProductores() as $productor){
    $admin_viewproduct_page->setContent("brand_id", $productor->getId());
    $admin_viewproduct_page->setContent("brand_name", $productor->getName());
    
    // Seleziona automaticamente il brand corrente del prodotto
    if(isset($product) && $productor->getId() == $product->getProductor()->getId()){
        $admin_viewproduct_page->setContent("brand_selected", "selected");
    } else {
        $admin_viewproduct_page->setContent("brand_selected", "");
    }
}

// Inizializzo le immagini del prodotto
$max_images = 5;
$buffer = "";
$images_size = 0;

if(isset($product)){
    $images = $imageDAO->getAllImagesByProduct($product);    
    $images_size = count($images);

    for($i = 0; $i < $images_size; $i++){
        $buffer .= '<div class="img-placeholder-upload">';
        $buffer .= '<div class="img-uploaded-wrapper">';
        $buffer .= '<img src="'.$images[$i]->getPath().'" value="'.$images[$i]->getId().'" alt="Immagine prodotto" />';
        $buffer .= '<button class="delete-img-btn" title="Rimuovi immagine">✖</button>';
        $buffer .= '</div>';
        $buffer .= '</div>';
    }
}

// Inserisco i placeholder

for($i = 0; $i < ($max_images - $images_size); $i++){
    $buffer .= '<div class="img-placeholder-upload">';
    $buffer .= '<button class="add-img-btn" title="Aggiungi immagine">+</button>';
    $buffer .= '</div>';
}


// Inserisco i box delle immagini
$admin_viewproduct_page->setContent("other_product_images", $buffer);

/*
<div class="img-placeholder-upload">
<div class="img-uploaded-wrapper">
<img src="img\my_img\user_profile\img_3.jpg" alt="Immagine prodotto" />
<button class="delete-img-btn" title="Rimuovi immagine">✖</button>
</div>
</div>
*/


/*
<div class="img-placeholder-upload">
<button class="add-img-btn" title="Aggiungi immagine">+</button>
</div>
*/

?>