<?php 

class Request {
  public $body;
  public $query;
  public $path;
  public $method;

  public function __construct() {
    $this->body = $_POST;
    $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
    $this->path = isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO']: '/';
    $this->query = $_GET;
  }
}

