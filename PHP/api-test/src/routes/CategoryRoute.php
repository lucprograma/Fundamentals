<?php 
use Slim\Routing\RouteCollectorProxy;
use Controllers\CategoryController;

$categoryController = new CategoryController();

$app->group('/categories', function (\Slim\Routing\RouteCollectorProxy $group) use ($categoryController) {
    $group->get('', [$categoryController, 'getAllCategories']);
    $group->post('', [$categoryController, 'createCategory']);
    $group->put('/{id_category}', [$categoryController, 'updateCategory']);
    $group->patch('/{id_category}/state', [$categoryController, 'changeCategoryState']);
});
?>
