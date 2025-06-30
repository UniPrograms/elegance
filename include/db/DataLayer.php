<?php

require_once("DB_Connection.php");
require_once("dao/UserDAO.php");
require_once("dao/CategoryDAO.php");
require_once("dao/ProductorDAO.php");
require_once("dao/PaymentDAO.php");
require_once("dao/DeliveryDAO.php");
require_once("dao/ProductDAO.php");
require_once("dao/ImageDAO.php");
require_once("dao/FeatureDAO.php");
require_once("dao/ProductFeatureDAO.php");
require_once("dao/CartDAO.php");
require_once("dao/CartItemDAO.php");
require_once("dao/NotifyDAO.php");
require_once("dao/OrderDAO.php");
require_once("dao/OrderItemDAO.php");
require_once("dao/ReviewDAO.php");
require_once("dao/EvaluaionDAO.php");
require_once("dao/WishlistDAO.php");
require_once("dao/WishlistItemDAO.php");
require_once("dao/SexDAO.php");
require_once("dao/SizeDAO.php");
require_once("dao/ColorDAO.php");
require_once("dao/ArticleDAO.php");



class DataLayer{


    private ?DB_Connection $DBConnection;
    private ?PDO $conn;


    private UserDAO $userDAO;
    private CategoryDAO $categoryDAO;
    private ProductorDAO $productorDAO;
    private PaymentDAO $paymentDAO;
    private DeliveryDAO $deliveryDAO;
    private ProductDAO $productDAO;
    private ImageDAO $imageDAO;
    private FeatureDAO $featureDAO;
    private ProductFeatureDAO $productFeatureDAO;
    private CartDAO $cartDAO;
    private CartItemDAO $cartItemDAO;
    private NotifyDAO $notifyDAO;
    private OrderDAO $orderDAO;
    private OrderItemDAO $orderItemDAO;
    private ReviewDAO $reviewDAO;
    private EvaluationDAO $evaluationDAO;
    private WishlistDAO $wishlistDAO;
    private WishlistItemDAO $wishlistItemDAO;
    private SexDAO $sexDAO;
    private SizeDAO $sizeDAO;
    private ColorDAO $colorDAO;
    private ArticleDAO $articleDAO;




    public function __construct(DB_Connection $DBConnection) {
        $this->DBConnection = $DBConnection;
        $this->conn = $DBConnection->getConnection();
        $this->init();
    }

    public function getDBConnection(): ?DB_Connection{
        return $this->DBConnection;
    }

    public function getConnection(): ?PDO{
        return $this->DBConnection->getConnection();
    }

    
    public function init(){
        $this->userDAO = new UserDAO($this);
        $this->categoryDAO = new CategoryDAO($this);
        $this->productorDAO = new ProductorDAO($this);
        $this->paymentDAO = new PaymentDAO($this);
        $this->deliveryDAO = new DeliveryDAO($this);
        $this->productDAO = new ProductDAO($this);
        $this->imageDAO = new ImageDAO($this);
        $this->featureDAO = new FeatureDAO($this);
        $this->productFeatureDAO = new ProductFeatureDAO($this);
        $this->cartDAO = new CartDAO($this);
        $this->cartItemDAO = new CartItemDAO($this);
        $this->notifyDAO = new NotifyDAO($this);
        $this->orderDAO = new OrderDAO($this);
        $this->orderItemDAO = new OrderItemDAO($this);
        $this->reviewDAO = new ReviewDAO($this);
        $this->evaluationDAO = new EvaluationDAO($this);
        $this->wishlistDAO = new WishlistDAO($this);
        $this->wishlistItemDAO = new WishlistItemDAO($this);
        $this->sexDAO = new SexDAO($this);
        $this->sizeDAO = new SizeDAO($this);
        $this->colorDAO = new ColorDAO($this);
        $this->articleDAO = new ArticleDAO($this);

    }


    public function getUserDAO(): UserDAO{
        return $this->userDAO;
    }

    public function getCategoryDAO(): CategoryDAO{
        return $this->categoryDAO;
    }

    public function getProductorDAO(): ProductorDAO{
        return $this->productorDAO;
    }

    public function getPaymentDAO(): PaymentDAO{
        return $this->paymentDAO;
    }

    public function getDeliveryDAO(): DeliveryDAO{
        return $this->deliveryDAO;
    }

    public function getProductDAO(): ProductDAO{
        return $this->productDAO;
    }

    public function getImageDAO(): ImageDAO{
        return $this->imageDAO;
    }

    public function getFeatureDAO(): FeatureDAO{
        return $this->featureDAO;
    }

    public function getProductFeatureDAO(): ProductFeatureDAO{
        return $this->productFeatureDAO;
    }

    public function getCartDAO(): CartDAO{
        return $this->cartDAO;
    }

    public function getCartItemDAO(): CartItemDAO{
        return $this->cartItemDAO;
    }

    public function getNotifyDAO(): NotifyDAO{
        return $this->notifyDAO;
    }

    public function getOrderDAO(): OrderDAO{
        return $this->orderDAO;
    }

    public function getOrderItemDAO(): OrderItemDAO{
        return $this->orderItemDAO;
    }
    
    public function getReviewDAO(): ReviewDAO{
        return $this->reviewDAO;
    }
    
    public function getEvaluationDAO(): EvaluationDAO{
        return $this->evaluationDAO;
    }

    public function getWishlistDAO(): WishlistDAO{
        return $this->wishlistDAO;
    }

    public function getWishlistItemDAO(): WishlistItemDAO{
        return $this->wishlistItemDAO;
    }

    public function getSexDAO(): SexDAO{
        return $this->sexDAO;
    }

    public function getSizeDAO(): SizeDAO{
        return $this->sizeDAO;
    }

    public function getColorDAO(): ColorDAO{
        return $this->colorDAO;
    }

    public function getArticleDAO(): ArticleDAO{
        return $this->articleDAO;
    }

}
?>