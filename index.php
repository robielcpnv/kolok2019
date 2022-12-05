<?php 
session_start();

// Set constants for the BASE stuff
define('BASE_URL', "http://".$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/.\\'));
define('BASE_DIR', dirname( __FILE__ ));

// Convert all errors, warnings and notices to exceptions
set_error_handler(function ($severity, $message, $filename, $lineno) { throw new ErrorException($message, 500, $severity, $filename, $lineno); });

// Get the request page or defaults to `home`
$page = 'offers';
if (isset($_GET["page"]) && !empty(trim($_GET["page"]))) {
  $page = preg_replace("/\W/", '_', trim($_GET["page"]));
}

// Get the logged in user
include(BASE_DIR . "/src/libs/auth.php");
$current_user = getCurrentUser();

// Any error in user code must be caught and reported as an error
try {
  // Run the page controller if any
  $controller = BASE_DIR . "/src/controllers/".$page.".php";
  if (file_exists($controller)) include($controller);
}
catch (Exception $error) {
  $page = "error";
}

// Does the view exist?
$view = BASE_DIR . "/src/views/".$page.".php";
if (!file_exists($view)) {
  // No, it's a 404
  $error = new Exception("La page demandée n'existe pas!", 404);
  $page = "error";
  $view = BASE_DIR . "/src/views/".$page.".php";
}

// Set the HTTP error code in case of an error
if ($page == 'error') {
  header($_SERVER["SERVER_PROTOCOL"]." ".$error->getCode());
}

// Render the layout
include(BASE_DIR . "/src/layout.php");
