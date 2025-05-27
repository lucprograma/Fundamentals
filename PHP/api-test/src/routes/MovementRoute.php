<?php
use Slim\Routing\RouteCollectorProxy;
use Controllers\MovementController;

$app->group('/movements', function (RouteCollectorProxy $group) {
    $controller = new MovementController();

    $group->get('', [$controller, 'getMovements']);
    $group->post('', [$controller, 'createMovement']);
    $group->delete('/{id_movement}', [$controller, 'deleteMovement']);
});
?>