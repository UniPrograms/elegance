<?php

class ImagePathManager {

    private const BASE_PATH = "img/my_img/";

    private string $sourcePath;
    private string $relativeDestinationPath;
    private string $newFileName;
    private ?string $base64String = null;

    // Costruttore per file temporaneo
    public function __construct(string $sourcePath, string $relativeDestinationPath, string $newFileName) {
        $this->sourcePath = $sourcePath;
        $this->relativeDestinationPath = trim($relativeDestinationPath, "/");
        $this->newFileName = $newFileName;
    }

    // Costruttore statico per base64
    public static function fromBase64(string $base64String, string $relativeDestinationPath, string $newFileName): self {
        $obj = new self('', $relativeDestinationPath, $newFileName);
        $obj->base64String = $base64String;
        return $obj;
    }

    // Gestione classica: file temporaneo
    public function moveUploadedFile(): ?string {
        $fullDestinationDirectory = self::BASE_PATH . $this->relativeDestinationPath;
        if (!is_dir($fullDestinationDirectory)) {
            if (!mkdir($fullDestinationDirectory, 0755, true)) {
                return null;
            }
        }
        $destinationPath = rtrim($fullDestinationDirectory, "/") . "/" . $this->newFileName;
        if (!move_uploaded_file($this->sourcePath, $destinationPath)) {
            return null;
        }
        return $destinationPath;
    }

    // Gestione base64
    public function moveBase64(): ?string {
        if ($this->base64String === null) return null;
        $fullDestinationDirectory = self::BASE_PATH . $this->relativeDestinationPath;
        if (!is_dir($fullDestinationDirectory)) {
            if (!mkdir($fullDestinationDirectory, 0755, true)) {
                return null;
            }
        }
        $destinationPath = rtrim($fullDestinationDirectory, "/") . "/" . $this->newFileName;
        $data = $this->base64String;
        if (preg_match('/^data:image\\/(png|jpeg|jpg);base64,/', $data)) {
            $data = substr($data, strpos($data, ',') + 1);
            $data = base64_decode($data);
            if ($data === false) {
                return null;
            }
        } else {
            return null;
        }
        if (file_put_contents($destinationPath, $data) === false) {
            return null;
        }
        return $destinationPath;
    }
}

?>