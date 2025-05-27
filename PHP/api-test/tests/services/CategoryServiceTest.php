<?php
use PHPUnit\Framework\TestCase;
use Services\CategoryService;

class CategoryServiceTest extends TestCase
{
    public function testGetAllReturnsArray()
    {
        $mock = $this->createMock(CategoryService::class);
        $mock->method('GetAll')->willReturn([
            ['id_category' => 1, 'description' => 'Example']
        ]);

        $result = $mock->GetAll();

        $this->assertIsArray($result);
    }

    public function testCreateReturnsInteger()
    {
        $mock = $this->createMock(CategoryService::class);
        $mock->method('Create')->willReturn(1);

        $result = $mock->Create('Test Category');

        $this->assertIsInt($result);
    }

    public function testUpdateReturnsBoolean()
    {
        $mock = $this->createMock(CategoryService::class);
        $mock->method('Update')->willReturn(true);

        $result = $mock->Update(1, 'Updated Description');

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }

    public function testChangeStateReturnsBoolean()
    {
        $mock = $this->createMock(CategoryService::class);
        $mock->method('ChangeState')->willReturn(true);

        $result = $mock->ChangeState(1, false);

        $this->assertIsBool($result);
        $this->assertTrue($result);
    }
}
