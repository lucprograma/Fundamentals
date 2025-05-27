<?php
namespace Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Services\MovementService;
use Validators\MovementValidator;

class MovementController {
    private $movementService;

    public function __construct() {
        $this->movementService = new MovementService();
    }

    public function getMovements(Request $request, Response $response, $args): Response {
        $params = $request->getQueryParams();
        $id_product = $params['id_product'] ?? null;
        $id_category = $params['id_category'] ?? null;

        try {
            $movements = $this->movementService->Get($id_product, $id_category);
            $response->getBody()->write(json_encode($movements));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $error = json_encode(['error' => $e->getMessage()]);
            $response->getBody()->write($error);
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function createMovement(Request $request, Response $response, $args): Response {
        $data = json_decode($request->getBody()->getContents(), true);

        if (
            !MovementValidator::validateIdProduct($data['id_product'] ?? null) ||
            !MovementValidator::validateQuantity($data['quantity'] ?? null) ||
            !MovementValidator::validateType($data['type'] ?? null) ||
            !MovementValidator::validateComments($data['comments'] ?? null)
        ) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input data.']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $lastInsertId = $this->movementService->Create($data);
            $response->getBody()->write(json_encode(['Last Insert ID' => $lastInsertId]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    public function deleteMovement(Request $request, Response $response, $args): Response {
        $id_movement = $args['id_movement'] ?? null;

        if (!MovementValidator::validateId($id_movement)) {
            $response->getBody()->write(json_encode(['error' => 'Invalid movement ID.']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $this->movementService->Delete($id_movement);
            $response->getBody()->write(json_encode(['message' => 'Movement deleted successfully.']));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}
?>
