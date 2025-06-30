<?php

require_once("include/model/proxy/ReviewProxy.php");   


class ReviewDAO extends DAO{


    private PDOStatement $stmtGetReviewById;
    private PDOStatement $stmtGetAllReviews;
    private PDOStatement $stmtGetReviewByProduct;
    private PDOStatement $stmtGetReviewByUser;
    private PDOStatement $stmtInsertReview;
    private PDOStatement $stmtUpdateReview;
    private PDOStatement $stmtDeleteReview;



    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
        parent::__construct($dataLayer);
        $this->init();
    }



    // Inizializzazione degli TegetTextement
    public function init(): void {
        $this->stmtGetReviewById = $this->conn->prepare("SELECT * FROM RECENSIONE WHERE ID = ?;");
        $this->stmtGetAllReviews = $this->conn->prepare("SELECT * FROM RECENSIONE;");
        $this->stmtGetReviewByProduct = $this->conn->prepare("SELECT * FROM RECENSIONE WHERE ID_PRODOTTO = ?;");
        $this->stmtGetReviewByUser = $this->conn->prepare("SELECT * FROM RECENSIONE WHERE ID_UTENTE = ?;");
        $this->stmtInsertReview = $this->conn->prepare("INSERT INTO RECENSIONE (TESTO, ID_PRODOTTO, ID_UTENTE) VALUES (?,?,?);");
        $this->stmtUpdateReview = $this->conn->prepare("UPDATE RECENSIONE SET TESTO = ?, ID_PRODOTTO = ?, ID_UTENTE = ? WHERE ID = ?;");
        $this->stmtDeleteReview = $this->conn->prepare("DELETE FROM RECENSIONE WHERE ID = ?;");
    }

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getReviewById(int $id){
        $this->stmtGetReviewById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetReviewById->execute();

        $rs = $this->stmtGetReviewById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createReview($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAllReviews(): array {
        $this->stmtGetAllReviews->execute();
        $result = [];

        while ($rs = $this->stmtGetAllReviews->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createReview($rs);
        }
        return $result;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getReviewByProduct(Product $product): array {
        $this->stmtGetReviewByProduct->bindValue(1, $product->getId(), PDO::PARAM_INT);
        $this->stmtGetReviewByProduct->execute();

        $result = [];

        while ($rs = $this->stmtGetReviewByProduct->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createReview($rs);
        }
        return $result;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getReviewByUser(User $user): array {
        $this->stmtGetReviewByUser->bindValue(1, $user->getId(), PDO::PARAM_STR);
        $this->stmtGetReviewByUser->execute();

        $result = [];

        while ($rs = $this->stmtGetReviewByUser->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createReview($rs);
        }
        return $result;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function storeReview(Review $review): bool {
        if ($review->getId() !== null) { 
            $this->stmtUpdateReview->bindValue(1, $review->getText(), PDO::PARAM_INT);
            $this->stmtUpdateReview->bindValue(2, $review->getProduct()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateReview->bindValue(3, $review->getUser()->getId(), PDO::PARAM_INT);
            $this->stmtUpdateReview->bindValue(4, $review->getId(), PDO::PARAM_INT);

            return $this->stmtUpdateReview->execute();
        } else {
            $this->stmtInsertReview->bindValue(1, $review->getText(), PDO::PARAM_INT);
            $this->stmtInsertReview->bindValue(2, $review->getProduct()->getId(), PDO::PARAM_INT);
            $this->stmtInsertReview->bindValue(3, $review->getUser()->getId(), PDO::PARAM_INT);

            return $this->stmtInsertReview->execute();
        }
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function deleteReview(Review $review): bool {
        $this->stmtDeleteReview->bindValue(1, $review->getId(), PDO::PARAM_INT);
        return $this->stmtDeleteReview->execute();
    }



    // Metodi privati

    private function createReview(array $rs): Review {
        $review = new ReviewProxy($this->dataLayer);
        $review->setId($rs['ID']);
        $review->setText($rs['TESTO']);
        $review->setDate($rs['DATE']);
        $review->setProductId($rs["ID_PRODOTTO"]);
        $review->setUserId($rs["ID_UTENTE"]);
        return $review;
    }



}

?>
