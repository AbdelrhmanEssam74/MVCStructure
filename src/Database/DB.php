<?php

namespace PROJECT\Database;

use PROJECT\Database\Concerns\ConnectsTo;
use PROJECT\Database\Managers\Contracts\DatabaseManager;

class DB
{
  use ConnectsTo;

  protected DatabaseManager $manager;

  public function __construct(DatabaseManager $manager)
  {
    $this->manager = $manager;
  }

  protected function init(): null
  {
    return self::connect($this->manager);
  }

  protected function row(string $query, $value = [])
  {
    return $this->manager->query($query, $value);
  }

  protected function create(array $data)
  {
    return $this->manager->create($data);
  }

  protected function read($columns = "*", $filter = null)
  {
    return $this->manager->read($columns, $filter);
  }

  protected function update($column, $value, $attributes)
  {
    return $this->manager->update($column, $value, $attributes);
  }

  protected function delete($column, $value): mixed
  {
    return $this->manager->delete($column, $value);
  }

  public function __call($method, $args)
  {
    if (method_exists($this, $method)) {
      return call_user_func_array([$this, $method], $args);
    }
  }
}
