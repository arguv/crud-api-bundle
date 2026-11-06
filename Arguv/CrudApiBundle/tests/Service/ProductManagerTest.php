<?php

namespace Arguv\CrudApiBundle\Tests\Service;

use Arguv\CrudApiBundle\Entity\Product;
use Arguv\CrudApiBundle\Service\ProductManager;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class ProductManagerTest extends TestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ProductManager
     */
    private $manager;

    protected function setUp()
    {
        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manager = new ProductManager($this->entityManager, Product::class);
    }

    public function testCreateNewEntityReturnsProduct()
    {
        $this->assertInstanceOf(Product::class, $this->manager->createNewEntity());
    }

    public function testUpdateEntitySetsFieldsAndFlushes()
    {
        $this->entityManager->expects($this->once())
            ->method('flush');

        $product = new Product();

        $this->assertTrue($this->manager->updateEntity($product, array(
            'name' => ' Smith ',
            'description' => ' A description ',
        )));

        $this->assertSame('Smith', $product->getName());
        $this->assertSame('A description', $product->getDescription());
    }

    public function testInsertEntityPersistsAndFlushes()
    {
        $product = new Product();

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($product);
        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->manager->insertEntity($product, array(
            array(
                'name' => 'Smith',
                'description' => 'A description',
            ),
        ));

        $this->assertSame('Smith', $product->getName());
        $this->assertSame('A description', $product->getDescription());
    }

    public function testDeleteEntityRemovesAndFlushes()
    {
        $product = new Product();

        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with($product);
        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->assertTrue($this->manager->deleteEntity($product));
    }

    public function testInvalidPayloadIsRejected()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product name and description are required.');

        $this->manager->updateEntity(new Product(), array(
            'name' => 'Smith',
        ));
    }

    public function testMultipleProductsAreRejected()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product data must contain exactly one product.');

        $this->manager->updateEntity(new Product(), array(
            array('name' => 'Smith', 'description' => 'First'),
            array('name' => 'Jones', 'description' => 'Second'),
        ));
    }

    public function testNameLongerThanColumnLimitIsRejected()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product name cannot exceed 100 characters.');

        $this->manager->updateEntity(new Product(), array(
            'name' => str_repeat('a', 101),
            'description' => 'A description',
        ));
    }
}
