<?php

require __DIR__.'/Request.php';
require __DIR__.'/Response.php';

class Application {
  private $request;
  public $response;
  private $routes = [];
  private $middlewares = [];
  private $current_middleware = 0;

  public function __construct() {
    $this->request = new Request();
    $this->response = new Response();
  }

  public function route(string $path, callable ...$callback) {
    $this->routes[$path] = $callback;
  }

  public function use(callable $middleware) {
    array_push($this->middlewares, $middleware);
  }

  private function run_middlewares() {
    foreach ($this->middlewares as $middleware) {
      $middleware($this->request);
    }
  }

  private function next($route) {
    // run the next middleware for a given route
    return function() use($route) {
      $this->current_middleware += 1;
      if(isset($this->routes[$route][$this->current_middleware])) {
        return $this->routes[$route][$this->current_middleware]($this->request, $this->response, $this->next($route));
      }
      return;
    };
  }

  private function resolve() {
    $this->current_middleware = 0;
    if(!isset($this->routes[$this->request->path])) {
      // this path is not configured
      http_response_code(404);
      echo "404 NOT FOUND";
    } else {
      // the path is configured
      echo $this->routes[$this->request->path][0]($this->request, $this->response, $this->next($this->request->path));
    }
  }

  public function run() {
    $this->run_middlewares();
    $this->resolve();
  }
}

