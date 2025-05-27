<?php
namespace Services;

use Config\Database;
use PDO;
use PDOException;
use Exception;

class MovementService {
    private PDO $pdo;

    public function __construct() {
        try {
            $this->pdo = Database::Connect();
        } catch (PDOException $e) {
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }

    public function Get(int $id_product = null,int $id_category = null): Array | Exception{
        try {
            $query = "
                SELECT m.*, p.name AS product_name, c.description AS category_name
                FROM movements m
                JOIN products p ON m.id_product = p.id_product
                JOIN categories c ON p.id_category = c.id_category
            ";
            $conditions = [];
            $params = [];

            if ($id_product) {
                $conditions[] = "m.id_product = :id_product";
                $params[':id_product'] = $id_product;
            }

            if ($id_category) {
                $conditions[] = "p.id_category = :id_category";
                $params[':id_category'] = $id_category;
            }

            if ($conditions) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            $query .= " ORDER BY m.movement_datetime DESC";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error retrieving movements: " . $e->getMessage());
        }
    }

    public function Create(array $data): int | Exception {
        try {
            $this->pdo->beginTransaction();

            $quantity = $data['quantity'];
            if ($data['type'] === 'out') {
                $quantity = -abs($quantity);
            }

            $stmt = $this->pdo->prepare("
                INSERT INTO movements (id_product, quantity, comments)
                VALUES (:id_product, :quantity, :comments)
            ");
            $stmt->bindParam(':id_product', $data['id_product'], PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':comments', $data['comments'], PDO::PARAM_STR);
            $stmt->execute();
            $lastInsertId = $this->pdo->lastInsertId();

            $stmt = $this->pdo->prepare("
                UPDATE products SET stock_quantity = stock_quantity + :quantity
                WHERE id_product = :id_product
            ");
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':id_product', $data['id_product'], PDO::PARAM_INT);
            $stmt->execute();
            $this->pdo->commit();
            return $lastInsertId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Error creating movement: " . $e->getMessage());
        }
    }

    public function Delete(int $id_movement): bool | Exception {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("SELECT id_product, quantity FROM movements WHERE id_movement = :id_movement");
            $stmt->bindParam(':id_movement', $id_movement, PDO::PARAM_INT);
            $stmt->execute();
            $movement = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$movement) {
                throw new Exception("Movement not found.");
            }

            $stmt = $this->pdo->prepare("
                DELETE FROM movements WHERE id_movement = :id_movement
            ");
            $stmt->bindParam(':id_movement', $id_movement, PDO::PARAM_INT);
            $stmt->execute();

            $inverseQuantity = -$movement['quantity'];
            $stmt = $this->pdo->prepare("
                UPDATE products SET stock_quantity = stock_quantity + :quantity
                WHERE id_product = :id_product
            ");
            $stmt->bindParam(':quantity', $inverseQuantity, PDO::PARAM_INT);
            $stmt->bindParam(':id_product', $movement['id_product'], PDO::PARAM_INT);
            $stmt->execute();

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Error deleting movement: " . $e->getMessage());
        }
    }
}
?>
