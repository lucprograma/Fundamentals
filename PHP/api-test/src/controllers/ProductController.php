<?php
namespace Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Services\ProductService;
use Validators\ProductValidator;

class ProductController {
    private $productService;

    public function __construct() {
        $this->productService = new ProductService();
    }

    public function getProducts(Request $request, Response $response, $args): Response {
        $id = $args['id_product'] ?? null;

        if ($id && !ProductValidator::validateId($id)) {
            $response->getBody()->write(json_encode(['error' => 'Invalid product ID']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $products = $this->productService->Get($id);
        $response->getBody()->write(json_encode($products));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createProduct(Request $request, Response $response): Response {
        $data = json_decode($request->getBody()->getContents(), true);

        if (
            !ProductValidator::validateCategoryId($data['id_category'] ?? null) ||
            !ProductValidator::validateName($data['name'] ?? '') ||
            !ProductValidator::validateAdditionalInfo($data['additional_info'] ?? null) ||
            !ProductValidator::validatePrice($data['price'] ?? null) ||
            !ProductValidator::validateStock($data['stock_quantity'] ?? null)
        ) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input data']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $lastInsertId = $this->productService->Create($data);
        $response->getBody()->write(json_encode(['Last Insert ID' => $lastInsertId]));
        return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    }

    public function updateProduct(Request $request, Response $response, $args): Response {
        $id = $args['id_product'];
        $data = json_decode($request->getBody()->getContents(), true);

        if (
            !ProductValidator::validateId($id) ||
            !ProductValidator::validateName($data['name'] ?? '') ||
            !ProductValidator::validateAdditionalInfo($data['additional_info'] ?? null) ||
            !ProductValidator::validatePrice($data['price'] ?? null) ||
            !ProductValidator::validateStock($data['stock_quantity'] ?? null)
        ) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $this->productService->Update($id, $data);
        $response->getBody()->write(json_encode(['message' => 'Product updated']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteProduct(Request $request, Response $response, $args): Response {
        $id = $args['id_product'];

        if (!ProductValidator::validateId($id)) {
            $response->getBody()->write(json_encode(['error' => 'Invalid ID']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $this->productService->Delete($id);
        $response->getBody()->write(json_encode(['message' => 'Product deleted']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function changeProductState(Request $request, Response $response, $args): Response {
        $id = $args['id_product'];
        $data = json_decode($request->getBody()->getContents(), true);

        if (
            !ProductValidator::validateId($id) ||
            !ProductValidator::validateState($data['state'] ?? null)
        ) {
            $response->getBody()->write(json_encode(['error' => 'Invalid data']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $this->productService->ChangeState($id, $data['state']);
        $response->getBody()->write(json_encode(['message' => 'Product state updated']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
?>