<?php
namespace ZF2DoctrineTools\View\Helper;
use Zend\View\Helper\AbstractHelper;
 
class ThisRouteHelper extends AbstractHelper
{
	private $routeName;
	
	public function __construct($e) {
		$route = $e->getRouteMatch();
		if($route) {
		    $this->routeName = $route->getMatchedRouteName(); 
		}
		else {
		    $this->routeName = '';
		}
	}
	
    public function __invoke()
    {
        return $this->routeName;
    }
}