<?php

use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

/**
* 
*/
class Uuid{
  
  public static function next(){
    $uuid = Ramsey\Uuid\Uuid::uuid4();
    return $uuid->toString();
  }
}

?>