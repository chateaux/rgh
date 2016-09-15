<?php
namespace Application\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class RedirectPlugin extends AbstractPlugin {

    public function redirectParams()
    {
        $redirectTo = (isset($_GET['redirectTo'])) ? $_GET['redirectTo'] : '';
        $queryParams = (null == $redirectTo) ? [] : ['query' => [ 'redirectTo'=> $redirectTo]];

        return $queryParams;
    }

}