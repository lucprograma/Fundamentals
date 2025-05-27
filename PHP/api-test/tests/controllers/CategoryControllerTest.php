<?php

use PHPUnit\Framework\TestCase;
use Controllers\CategoryController;
use Nyholm\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Response as SlimResponse;

class CategoryControllerTest extends TestCase
{
    public function testGetAllCategories()
    {
        $controller = new CategoryController();

        $request = $this->createMock(ServerRequestInterface::class);
        $response = new SlimResponse();
        $args = [];

        $result = $controller->getAllCategories($request, $response, $args);
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testCreateCategoryValid()
    {
        $controller = new CategoryController();

        $description = 'Example category';
        $stream = (new StreamFactory())->createStream(json_encode(['description' => $description]));

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getBody')->willReturn($stream);

        $response = new SlimResponse();
        $args = [];

        $result = $controller->createCategory($request, $response, $args);
        $this->assertEquals(201, $result->getStatusCode());
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testCreateCategoryInvalid()
    {
        $controller = new CategoryController();

        $stream = (new StreamFactory())->createStream(json_encode(['description' => '']));

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getBody')->willReturn($stream);

        $response = new SlimResponse();
        $args = [];

        $result = $controller->createCategory($request, $response, $args);
        $this->assertEquals(400, $result->getStatusCode());
    }

    public function testUpdateCategoryValid()
    {
        $controller = new CategoryController();

        $stream = (new StreamFactory())->createStream(json_encode(['description' => 'Updated category']));
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getBody')->willReturn($stream);

        $response = new SlimResponse();
        $args = ['id_category' => 1];

        $result = $controller->updateCategory($request, $response, $args);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function testUpdateCategoryInvalidId()
    {
        $controller = new CategoryController();

        $stream = (new StreamFactory())->createStream(json_encode(['description' => 'Updated category']));
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getBody')->willReturn($stream);

        $response = new SlimResponse();
        $args = ['id_category' => 'invalid'];

        $result = $controller->updateCategory($request, $response, $args);
        $this->assertEquals(400, $result->getStatusCode());
    }

    public function testUpdateCategoryInvalidDescription()
    {
        $controller = new CategoryController();

        $stream = (new StreamFactory())->createStream(json_encode(['description' => '']));
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getBody')->willReturn($stream);

        $response = new SlimResponse();
        $args = ['id_category' => 1];

        $result = $controller->updateCategory($request, $response, $args);
        $this->assertEquals(400, $result->getStatusCode());
    }

    public function testChangeCategoryStateValid()
    {
        $controller = new CategoryController();

        $stream = (new StreamFactory())->createStream(json_encode(['state' => true]));
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getBody')->willReturn($stream);

        $response = new SlimResponse();
        $args = ['id_category' => 1];

        $result = $controller->changeCategoryState($request, $response, $args);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function testChangeCategoryStateInvalidId()
    {
        $controller = new CategoryController();

        $stream = (new StreamFactory())->createStream(json_encode(['state' => true]));
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getBody')->willReturn($stream);

        $response = new SlimResponse();
        $args = ['id_category' => 'invalid'];

        $result = $controller->changeCategoryState($request, $response, $args);
        $this->assertEquals(400, $result->getStatusCode());
    }

    public function testChangeCategoryStateInvalidState()
    {
        $controller = new CategoryController();

        $stream = (new StreamFactory())->createStream(json_encode(['state' => 'not_bool']));
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getBody')->willReturn($stream);

        $response = new SlimResponse();
        $args = ['id_category' => 1];

        $result = $controller->changeCategoryState($request, $response, $args);
        $this->assertEquals(400, $result->getStatusCode());
    }
}
