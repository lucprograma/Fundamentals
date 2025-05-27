<?php
namespace Controllers;
use Services\CategoryService;
use Validators\CategoryValidator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CategoryController {
    private CategoryService $categoryService;

    public function __construct() {
        $this->categoryService = new CategoryService();
    }

    public function getAllCategories(Request $request, Response $response, $args): Response {
        try {
            $categories = $this->categoryService->GetAll();
            $payload = json_encode($categories);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $e) {
            $error = json_encode(['error' => 'Failed to retrieve categories.']);
            $response->getBody()->write($error);
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function createCategory(Request $request, Response $response, $args): Response {
        
        $body = $request->getBody();
        $data = json_decode($body->getContents());

        if (!CategoryValidator::validateDescription($data->description ?? '')) {
            $response->getBody()->write(json_encode(['error' => 'Description is required and must be between 3 and 255 characters.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $lastInsertId = $this->categoryService->Create($data->description);
            $response->getBody()->write(json_encode(['Last Insert ID' => $lastInsertId]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (\Throwable $e) {
            $response->getBody()->write(json_encode(['error' => 'Failed to create category.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function updateCategory(Request $request, Response $response, $args): Response {
        $id_category = $args['id_category'];
              
        if (!CategoryValidator::validateId($id_category)) {
            $response->getBody()->write(json_encode(['error' => 'Invalid category ID.']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $body = $request->getBody();
        $data = json_decode($body->getContents());

        if (!CategoryValidator::validateDescription($data->description ?? '')) {
            $response->getBody()->write(json_encode(['error' => 'Description is required and must be between 3 and 255 characters.']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $this->categoryService->Update($id_category, $data->description);
            $response->getBody()->write(json_encode(['message' => 'Category updated successfully.']));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $e) {
            throw new \Exception("Failed to update category.");
        }
    }

    public function changeCategoryState(Request $request, Response $response, $args): Response {
        $id_category = $args['id_category'];

        if (!CategoryValidator::validateId($id_category)) {
            $response->getBody()->write(json_encode(['error' => 'Invalid category ID.']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $body = $request->getBody();
        $data = json_decode($body->getContents(), true);
        if(!is_array($data)){
            $response->getBody()->write(json_encode(['error' => 'Invalid input data.']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');            
        }

        if (!CategoryValidator::validateState($data['state'] ?? null)) {
            $response->getBody()->write(json_encode(['error' => 'State must be a boolean.']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $this->categoryService->ChangeState($id_category, $data['state']);
            $response->getBody()->write(json_encode(['message' => 'Category state changed successfully.']));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $e) {
            throw new \Exception("Failed to change category state.");
        }
    }
}
?>


