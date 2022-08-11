<?php

declare(strict_types=1);

namespace Blog\Test\Unit;

use Blog\Database;
use Blog\LatestPosts;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\once;

class LatestPostsTest extends TestCase
{
  private LatestPosts $object;

  /**
   * @var MockObject|Database
   */
  private MockObject $database;

  private MockObject $pdo;

  private MockObject $pdoStatement;
  
  protected function setUp(): void
  {
    $this->database = $this->createMock(Database::class);

    $this->pdo = $this->createMock(PDO::class);

    $this->database->expects($this->any())
      ->method('getConnection')
      ->willReturn($this->pdo);

    $this->pdoStatement = $this->createMock(PDOStatement::class);

    $this->object = new LatestPosts($this->database);
  }

  public function testGetEmpty(): void
  {
    $limit = 0;
    $expectedResult = [];

    $this->pdo->expects($this->once())
      ->method('prepare')
      ->willReturn($this->pdoStatement);

    $this->pdoStatement->expects($this->once())
      ->method('execute');

    $this->pdoStatement->expects($this->once())
      ->method('fetchAll')
      ->willReturn($expectedResult);

    $result = $this->object->get($limit);
    $this->assertEmpty($result);
  }

  public function testGet()
  {
    $limit = 3;
    $expectedResult = [
      [
        'title' => 'My Post',
        'author' => 'Kate'
      ]
    ];

    $this->pdo->expects($this->once())
      ->method('prepare')
      ->with($this->equalTo('SELECT * FROM post ORDER BY published_date DESC LIMIT :limit'))
      ->willReturn($this->pdoStatement);

    $this->pdoStatement->expects($this->once())
      ->method('execute');

    $this->pdoStatement->expects($this->once())
      ->method('fetchAll')
      ->willReturn($expectedResult);

    $this->pdoStatement->expects($this->once())
      ->method('bindParam')
      ->with($this->equalTo(':limit'), $this->equalTo($limit), $this->equalTo(PDO::PARAM_INT));

    $result = $this->object->get($limit);
    $this->assertNotEmpty($result);
  }
}