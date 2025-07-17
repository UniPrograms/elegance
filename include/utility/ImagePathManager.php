<?php

class ImagePathManager {

    private const BASE_PATH = "img/my_img/";

    private string $sourcePath;
    private string $relativeDestinationPath;
    private string $newFileName;

    public function __construct(string $sourcePath, string $relativeDestinationPath, string $newFileName) {
        $this->sourcePath = $sourcePath;
        $this->relativeDestinationPath = trim($relativeDestinationPath, "/");
        $this->newFileName = $newFileName;
    }

    public function move(): string {
        // Costruisce il path completo della directory di destinazione
        $fullDestinationDirectory = self::BASE_PATH . $this->relativeDestinationPath;

        // Crea la directory se non esiste
        if (!is_dir($fullDestinationDirectory)) {
            if (!mkdir($fullDestinationDirectory, 0755, true)) {
                throw new Exception("Errore nella creazione della directory: $fullDestinationDirectory");
            }
        }

        // Costruisce il path completo del file finale
        $destinationPath = rtrim($fullDestinationDirectory, "/") . "/" . $this->newFileName;

        // Sposta il file dalla sorgente alla destinazione con il nuovo nome
        if (!move_uploaded_file($this->sourcePath, $destinationPath)) {
            throw new Exception("Errore nello spostamento del file.");
        }

        // Ritorna il path finale
        return $destinationPath;
    }
    
}

?>