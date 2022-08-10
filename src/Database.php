<?php

declare(strict_types=1);

namespace Blog;

use InvalidArgumentException;
use PDO;
use PDOException;

class Database
{
  /**
   * @var PDO
   */
  private PDO $connection;

  /**
   * @param PDO $connection
   */
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }

  /**
   * @return PDO
   */
  public function getConnection(): PDO
  {
    return $this->connection;
  }
}