<?php

namespace Application\Controllers;

/**
 * 
 * @author TreinaWeb
 * 
 */
final class FrontController
{
  public static function dispatch(array $request)
  {
    $controller = 'Index';
    if (isset($request['controller']))
    {
      $controller = ucfirst($request['controller']);
      unset($request['controller']); 
    }
    $controller .= 'Controller';
    
    $action = 'index';
    if (isset($request['action']))
    {
      $action = $request['action'];
      unset($request['action']);
    }
    $action .= 'Action';    
    
    try{  
      $ns = "\\Application\\Controllers\\$controller";
      $pageController = new $ns();
      $pageController->execute($action);      
    }
    catch (Exception $e)
    {
      echo $e->getMessage();
    }
  }
}
