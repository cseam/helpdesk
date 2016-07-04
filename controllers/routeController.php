<?php

class routeController {
  private $_uri = array();
  private $_controler = array();
  // build collection of internal routes
  public function add($uri, $controler = null) {
    $this->_uri[] = $uri;
    $this->_controler[] = $controler;
  }
  // process the routes from uri
  public function process() {
    // explode uri as we are only interested in the top route at this point
    $baseurl = $_SERVER['REQUEST_URI'];
    // setup matches
    $matches = array();
    // check for matches
    foreach ($this->_uri as $key => $value) {
      isset($baseurl) ? $compare = $baseurl : $compare = "/";
        if (preg_match("#^$value(/{0,1})$#", $compare)) {
          // on match update matches and start controler for match
          $useControler = $this->_controler[$key];
          $matches[] = $this->_controler[$key];
          new $useControler();
        }
    }
    // check if no matches 404
    if (sizeof($matches) < 1) {
      // no matches display 404
      header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
      $error = new stdClass();
      $error->title = "404 Error";
      $error->message = "Opps! Page not found.";
      require_once "views/errorView.php";
    }
  }
}
