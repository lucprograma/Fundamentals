<?php
namespace Services;
use Config\Database;
use PDO;

class CategoryService {
   
private PDO $pdo;

    public function __construct() {
        try {
            $this->pdo = Database::Connect();
        } catch (PDOException $e) {
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }

    public function GetAll(): Array | Exception {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM categories");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error retrieving categories: " . $e->getMessage());
        }
    }

    public function Create(string $description): int | Exception {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO categories (description) VALUES (:description)");
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->execute();
            $lastInsertId = $this->pdo->lastInsertId();
            return $lastInsertId;
        } catch (PDOException $e) {
            throw new Exception("Error creating category: " . $e->getMessage());
        }
    }

    public function Update(int $id_category,string $description): bool | Exception {
        try {
            $stmt = $this->pdo->prepare("UPDATE categories SET description = :description, updated_at = CURRENT_TIMESTAMP WHERE id_category = :id_category");
            $stmt->bindParam(':id_category', $id_category, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error updating category: " . $e->getMessage());
        }
    }

   public function ChangeState(int $id_category,bool $state): bool | Exception {
        try {
            $stmt = $this->pdo->prepare("UPDATE categories SET is_enabled = :state WHERE id_category = :id_category");
            $stmt->bindParam(':id_category', $id_category, PDO::PARAM_INT);
            $stmt->bindParam(':state', $state, PDO::PARAM_BOOL);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error changing category state: " . $e->getMessage());
        }
    }
}
?>
