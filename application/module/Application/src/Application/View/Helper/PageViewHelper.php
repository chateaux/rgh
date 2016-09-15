<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class PageViewHelper extends AbstractHelper
{

    public function getPublicRightMenu()
    {
        return '<div class="col-sm-4 col-md-3">
                <div class="human-rights-section">
                    <div class="hr-logo">
                        <img src="assets/global/images/logo1.jpg" >
                    </div>
                    <div class="text">
                        <p>
                            Become a human rights activist for the RGH and hold Governments, Corporations and Individuals accountable
                            for actions that violate global treaties and local constitutions.
                        </p>
                        <p>
                            Our goal is to protect minority groups with specifics to the following rights:
                        </p>
                        <ol>
                            <li>Freedom of movement</li>
                            <li>Freedom of Association</li>
                            <li>Freedom from Slavery</li>
                        </ol>
                        <p>
                            Our goal is to collect and human rights violations and to use this compiled data to hold violators accountable for their actions.
                        </p>
                        <p>We are a privately funded  organization.</p>
                    </div>
                </div>
                <div class="human-rights-section">
                    <div class="hr-logo">
                        <img src="assets/global/images/logo2.jpg" >
                    </div>
                    <div class="text">
                        <p>A cornerstone of the Republic of Good Hope is the Universal Declaration of Human Rights declared in Paris in 1948.</p>
                        <p>We encourage your to read this document and to take the time to learn your rights. It is by knowing your rights that we can create a better world together.</p>
                        <p>
                            <a href="http://www.un.org/en/universal-declaration-human-rights/" target="_blank">View the Universal declaration of human rights</a></p>
                    </div>
                </div>
            </div>';

    }

    /**
     * Returns parts of the URI so we can set mennu options
     * @return array
     */
    public function getUriParts()
    {
        $uri_parts = $_SERVER['REQUEST_URI'];

        if (substr($uri_parts,0,1) == '/') {
            $uri_parts = substr($uri_parts,1);
        }
        $parts = explode('/',$uri_parts);

        return [
            'grand_parent' => strtolower(isset($parts[0]) ? $parts[0] : ''),
            'parent' => strtolower(isset($parts[1]) ? $parts[1] : ''),
            'child' => strtolower(isset($parts[2]) ? $parts[2] : ''),
            'grand_child' => strtolower(isset($parts[3]) ? $parts[3] : '')
        ];
    }



}
