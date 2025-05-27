<?php
namespace Test\Controllers;
#Imports
use PHPUnit\Framework\TestCase;
use Controllers\MovementController;
use Nylom\Psr7\Request;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Response as SlimResponse;

class MovementControllerTest extends TestCase
{
    public function testGetMovements(): void {
        $controller = new MovementController();
        $request = $this->CreateMock(ServerRequestInterface::class);
        $response = new SlimResponse();
        $args = [];
        $result = $controller->getMovements($request, $response, $args);
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }
    public function testCreateMovement(): void {
        $controller = new MovementController();
        $request = $this->CreateMock(ServerRequestInterface::class);
        $response = new SlimResponse();
        $stream = (new StreamFactory)->createStream(json_encode(["id_product" => 1, "quantity" => 2,"type" => "in","comments" => ""]));
        $request->method("getBody")->willReturn($stream);
        $args = [];
        $result = $controller->createMovement($request, $response, $args);
        fwrite(STDOUT, "Body: " . (string)$result->getBody() . "\n");
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertEquals(201, $result->getStatusCode(), "The request have been failed:");
    }
    public function testDeleteMovement(): void {
        $controller = new MovementController();
        $request = $this->CreateMock(ServerRequestInterface::class);
        $response = new SlimResponse();
        $args = ["id_movement" => "delete * from movements where 1 = 1"];
        $result = $controller->deleteMovement($request, $response, $args);
        fwrite(STDOUT, "Body: " . (string)$result->getBody() . "\n");

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertEquals(200, $result->getStatusCode(), "Something went wrong with the request");
    }

}



?>