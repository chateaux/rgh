<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function __construct(
    ) {
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function homeAction()
    {


        return new ViewModel();
    }

    public function faqAction()
    {
        return new ViewModel();
    }

    public function identityAction()
    {
        return new ViewModel();
    }

    public function passportAction()
    {
        return new ViewModel();
    }

    public function birthAction()
    {
        return new ViewModel();
    }

    public function marriageAction()
    {
        return new ViewModel();
    }

    public function companyAction()
    {
        return new ViewModel();
    }

    public function moneyAction()
    {
        return new ViewModel();
    }

    public function conveyanceAction()
    {
        return new ViewModel();
    }

    public function reportingAction()
    {
        return new ViewModel();
    }

}
