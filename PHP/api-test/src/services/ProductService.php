<?php
namespace Services;

use Config\Database;
use PDO;
use PDOException;
use Exception;

class ProductService {
    private PDO $pdo;

    public function __construct() {
        try {
            $this->pdo = Database::Connect();
        } catch (PDOException $e) {
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }

    public function Get(int $id_product = null): Array | Exception {
        try {
            if ($id_product) {
                $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id_product = :id_product");
                $stmt->bindParam(':id_product', $id_product, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $stmt = $this->pdo->prepare("SELECT * FROM products");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            throw new Exception("Error retrieving products: " . $e->getMessage());
        }
    }

    public function Create(array $data): int | Exception {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO products (id_category, name, additional_info, price, stock_quantity)
                VALUES (:id_category, :name, :additional_info, :price, :stock_quantity)
            ");
            $stmt->bindParam(':id_category', $data['id_category'], PDO::PARAM_INT);
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':additional_info', $data['additional_info'], PDO::PARAM_STR);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':stock_quantity', $data['stock_quantity'], PDO::PARAM_INT);
            $stmt->execute();
            $lastInsertId = $this->pdo->lastInsertId();
            return $lastInsertId;
        } catch (PDOException $e) {
            throw new Exception("Error creating product: " . $e->getMessage());
        }
    }

    public function Update(int $id_product,Array $data): bool | Exception {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE products
                SET name = :name,
                    additional_info = :additional_info,
                    price = :price,
                    stock_quantity = :stock_quantity,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id_product = :id_product
            ");
            $stmt->bindParam(':id_product', $id_product, PDO::PARAM_INT);
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':additional_info', $data['additional_info'], PDO::PARAM_STR);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':stock_quantity', $data['stock_quantity'], PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error updating product: " . $e->getMessage());
        }
    }

    public function Delete(int $id_product): bool | Exception {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM products WHERE id_product = :id_product");
            $stmt->bindParam(':id_product', $id_product, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception("Error deleting product: " . $e->getMessage());
        }
    }

    public function ChangeState(int $id_product,bool $state): bool | Exception {
        try {
            $stmt = $this->pdo->prepare("UPDATE products SET is_enabled = :state WHERE id_product = :id_product");
            $stmt->bindParam(':id_product', $id_product, PDO::PARAM_INT);
            $stmt->bindParam(':state', $state, PDO::PARAM_BOOL);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception("Error changing product state: " . $e->getMessage());
        }
    }
}
?>

