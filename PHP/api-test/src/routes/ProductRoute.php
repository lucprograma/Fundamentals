<?php
use Slim\Routing\RouteCollectorProxy;
use Controllers\ProductController;

$app->group('/products', function (RouteCollectorProxy $group) {
    $controller = new ProductController();

    $group->get('', [$controller, 'getProducts']);
    $group->get('/{id_product}', [$controller, 'getProducts']);
    $group->post('', [$controller, 'createProduct']);
    $group->put('/{id_product}', [$controller, 'updateProduct']);
    $group->delete('/{id_product}', [$controller, 'deleteProduct']);
    $group->patch('/{id_product}/state', [$controller, 'changeProductState']);
});
?>
