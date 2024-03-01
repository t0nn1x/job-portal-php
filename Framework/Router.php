<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

class Router {
  protected $routes = [];

  /**
   * Add a new route
   *
   * @param string $method
   * @param string $uri
   * @param string $action
   * @param array $middleware
   * 
   * @return void
   */
  public function registerRoute($method, $uri, $action, $middleware = []) {
    list($controller, $controllerMethod) = explode('@', $action);

    $uriPattern = preg_replace('/{([^}]+)}/', '(?P<$1>[^/]+)', $uri);
    $uriPattern = '#^' . $uriPattern . '$#';

    $this->routes[] = [
      'method' => $method,
      'uri_pattern' => $uriPattern,
      'uri' => $uri,
      'controller' => $controller,
      'controllerMethod' => $controllerMethod,
      'middleware' => $middleware
    ];
  }

  /**
   * Add a GET route
   * 
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * 
   * @return void
   */
  public function get($uri, $controller, $middleware = []) {
    $this->registerRoute('GET', $uri, $controller, $middleware);
  }

  /**
   * Add a POST route
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * 
   * @return void
   */
  public function post($uri, $controller, $middleware = []) {
    $this->registerRoute('POST', $uri, $controller, $middleware);
  }

  /**
   * Add a PUT route
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * 
   * @return void
   */
  public function put($uri, $controller, $middleware = []) {
    $this->registerRoute('PUT', $uri, $controller, $middleware);
  }

  /**
   * Add a DELETE route
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * 
   * @return void
   */
  public function delete($uri, $controller, $middleware = []) {
    $this->registerRoute('DELETE', $uri, $controller, $middleware);
  }

  /**
   * Route the request
   *
   * @param string $uri
   * @param string $method
   * @return void
   */
    public function route($uri, $method) {
      // Check for _method field in POST data
      if ($method === 'POST' && isset($_POST['_method'])) {
        $method = strtoupper($_POST['_method']);
      }

      foreach ($this->routes as $route) {
        if ($route['method'] === $method && preg_match($route['uri_pattern'], $uri, $matches)) {
          // Extract controller and controller method
          $controller = 'App\\Controllers\\' . $route['controller'];
          $controllerMethod = $route['controllerMethod'];

          // Instantiate the controller
          $controllerInstance = new $controller();

          // Apply middleware
          foreach($route['middleware'] as $middleware) {
            (new Authorize()) -> handle($middleware);
          }

          // Remove numeric keys from matches
          foreach ($matches as $key => $match) {
            if (is_int($key)) {
              unset($matches[$key]);
            }
          }

          // Call the method with parameters
          call_user_func_array([$controllerInstance, $controllerMethod], $matches);
          return;
        }
      }

      ErrorController::notFound();
    }
}
