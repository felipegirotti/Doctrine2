<?php

namespace Application\Controllers;

/**
 * 
 * @author TreinaWeb
 *
 */
abstract class PageController
{
  protected $viewAttributes = array();
  
  public function __set($name, $value)
  {
    $this->viewAttributes[$name] = $value;
  }
  
  public function __get($name)
  {
    return $this->viewAttributes[$name];
  }
  
  public function execute($action)
  {
    $this->$action();
    $page = str_replace('Action', '', $action);
    $path = str_replace('Controllers', 'Views', __DIR__);
    $controller = str_replace('Application\\Controllers\\', '', get_class($this));
    $controller = str_replace('Controller', '', $controller);
    $controller = strtolower($controller);
    require_once $path . "/$controller/$page.phtml";    
  }
}
