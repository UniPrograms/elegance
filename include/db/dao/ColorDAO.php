<?php

require_once("include/model/proxy/ColorProxy.php");


class ColorDAO extends DAO{


    private PDOStatement $stmtGetColorById;
    private PDOStatement $stmtGetAllColors;
    private PDOStatement $stmtGetColorByName;
    private PDOStatement $stmtInsertColor;
    private PDOStatement $stmtUpdateColor;
    private PDOStatement $stmtDeleteColor;
    private PDOStatement $stmtGetAvailableColorFromProductId;


    // Costruttore
    public function __construct(?DataLayer $dataLayer) {
    parent::__construct($dataLayer);
    $this->init();
}



    // Inizializzazione degli statement
    public function init(): void {
        $this->stmtGetColorById = $this->conn->prepare("SELECT * FROM COLORE WHERE ID = ?;");
        $this->stmtGetAllColors = $this->conn->prepare("SELECT * FROM COLORE;");
        $this->stmtGetColorByName = $this->conn->prepare("SELECT * FROM COLORE WHERE COLORE LIKE ?;");
        $this->stmtGetAvailableColorFromProductId = $this->conn->prepare("SELECT DISTINCT ID_COLORE, COLORE FROM ARTICOLO_PRODOTTO_COMPLETO WHERE ID_PRODOTTO = ?;");
    }

    // Statemetn

    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getColorById(int $id){
        $this->stmtGetColorById->bindValue(1, $id, PDO::PARAM_INT);
        $this->stmtGetColorById->execute();

        $rs = $this->stmtGetColorById->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createColor($rs) : null;
    }
    /**
     * 
     * 
     * 
     * 
     * 
     */
    public function getAvailableColorFromProductId(?int $product_id): array {
        $this->stmtGetAvailableColorFromProductId->bindValue(1, $product_id, PDO::PARAM_INT);
        $this->stmtGetAvailableColorFromProductId->execute();
        $result = [];

        while ($rs = $this->stmtGetAvailableColorFromProductId->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->getColorById($rs["ID_COLORE"]);
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
    public function getAllColors(): array {
        $this->stmtGetAllColors->execute();
        $result = [];

        while ($rs = $this->stmtGetAllColors->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $this->createColor($rs);
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
    public function getColorByName(string $name): ?Color {
        $this->stmtGetColorByName->bindValue(1, '%'.$name.'%', PDO::PARAM_STR);
        $this->stmtGetColorByName->execute();
        $rs = $this->stmtGetColorByName->fetch(PDO::FETCH_ASSOC);

        return $rs ? $this->createColor($rs) : null;
    }


    // Metodi privati

    private function createColor(array $rs): Color {
        $color = new ColorProxy($this->dataLayer);
        $color->setId($rs['ID']);
        $color->setColor($rs['COLORE']);
        return $color;
    }



}

?>
