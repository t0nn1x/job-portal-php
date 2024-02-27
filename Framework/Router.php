<?php

namespace Framework;

use App\Controllers\ErrorController;

class Router {
  protected $routes = [];

  /**
   * Add a new route
   *
   * @param string $method
   * @param string $uri
   * @param string $action
   * @return void
   */
  public function registerRoute($method, $uri, $action) {
    list($controller, $controllerMethod) = explode('@', $action);

    $uriPattern = preg_replace('/{([^}]+)}/', '(?P<$1>[^/]+)', $uri);
    $uriPattern = '#^' . $uriPattern . '$#';

    $this->routes[] = [
      'method' => $method,
      'uri_pattern' => $uriPattern,
      'uri' => $uri,
      'controller' => $controller,
      'controllerMethod' => $controllerMethod
    ];
  }

  /**
   * Add a GET route
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function get($uri, $controller) {
    $this->registerRoute('GET', $uri, $controller);
  }

  /**
   * Add a POST route
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function post($uri, $controller) {
    $this->registerRoute('POST', $uri, $controller);
  }

  /**
   * Add a PUT route
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function put($uri, $controller) {
    $this->registerRoute('PUT', $uri, $controller);
  }

  /**
   * Add a DELETE route
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function delete($uri, $controller) {
    $this->registerRoute('DELETE', $uri, $controller);
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
