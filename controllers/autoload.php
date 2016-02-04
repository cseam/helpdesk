<?php
// using spl_autoload_register to auto load classes instead of __autoload so doesnt clash with any future libries
// function used to auto load controlers when required
function controllerAutoload($controller_name) {
  if (file_exists("controllers/".$controller_name.".php")) {
    require_once "controllers/".$controller_name.".php";
  }
}
// function used to auto load controller methods/actions when required
function methodAutoload($method_name) {
  if (file_exists("controllers/actions/".$method_name.".php")) {
    require_once "controllers/actions/".$method_name.".php";
  }
}
// function used to auto load models when required
function modelAutoload($model_name) {
  if (file_exists("models/".$model_name.".php")) {
    require_once "models/".$model_name.".php";
  }
}
// register function with spl_autoload_register
spl_autoload_register('controllerAutoload');
spl_autoload_register('methodAutoload');
spl_autoload_register('modelAutoload');
