<?php

/**
 * Get the base path
 * 
 * @param string $path
 * @return string
 */
function basePath($path = '') {
  return __DIR__ . '/' . $path;
}

/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */
function loadView($name, $data = []) {
  $viewPath = basePath("views/{$name}.view.php");

  if (file_exists($viewPath)) {
    extract($data);
    require $viewPath;
  } else {
    echo "View '{$viewPath}' not found!";
  }
}

/**
 * Load a partial
 * 
 * @param string $name
 * @return void
 */
function loadPartial($name, $data = []) {
  $partialPath = basePath("views/partials/{$name}.php");

  if (file_exists($partialPath)) {
    extract($data);
    require $partialPath;
  } else {
    echo "Partial '{$partialPath}' not found!";
  }
}

/**
 * Inspect a value(s) 
 * 
 * @param mixed $value
 * @return void
 */
function inspectValue($value) {
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
}

/**
 * Inspect a value(s) and die 
 * 
 * @param mixed $value
 * @return void
 */
function inspectValueAndDie($value) {
  echo '<pre>';
  die(var_dump($value));
  echo '</pre>';
}

/**
 * Format salary
 *
 * @param string $salary
 * @return string Formatted Salary
 */
function formatSalary($salary) {
  return number_format(floatval($salary)) . '$';
}
