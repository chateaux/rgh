<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class FlashMessengerHelper extends AbstractHelper
{
    public function __invoke()
    {
        $flash = $this->getView()->flashMessenger();
        echo $flash->render('error',   ['alert', 'alert-dismissable', 'alert-danger']);
        echo $flash->render('info',    ['alert', 'alert-dismissable', 'alert-info']);
        echo $flash->render('default', ['alert', 'alert-dismissable', 'alert-warning']);
        echo $flash->render('success', ['alert', 'alert-dismissable', 'alert-success']);
    }
}
