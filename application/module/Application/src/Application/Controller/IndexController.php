<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Form\FormInterface;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;

class IndexController extends AbstractActionController
{
    private $renderer;
    private $verifyForm;

    public function __construct(
        RendererInterface $renderer,
        FormInterface $verifyForm
    ) {
        $this->renderer = $renderer;
        $this->verifyForm = $verifyForm;
    }

    /**
     * @return ViewModel
     */
    public function homeAction()
    {
        return new ViewModel();
    }

    public function verifyAction()
    {
        $prg = $this->prg();

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return new ViewModel(
                [
                    'form' => $this->verifyForm,
                ]
            );
        }

        if (strtoupper($prg['recordNumber']) == 'AZ196324052013440' and strtoupper($prg['verificationCode']) == 'VERIFYKXPGX5PAKQH') {
            $viewContent = new ViewModel(
                [
                    'recordNumber' => strtoupper($prg['recordNumber']),
                    'verificationCode' => $prg['verificationCode'],
                ]
            );
            $viewContent->setTemplate('pdf/verify-identity');
        } elseif (strtoupper($prg['recordNumber']) == 'RG74788H' and strtoupper($prg['verificationCode']) == 'VERIFYSBCCEBPLMNX') {
            $viewContent = new ViewModel(
                [
                    'recordNumber' => strtoupper($prg['recordNumber']),
                    'verificationCode' => $prg['verificationCode'],
                ]
            );
            $viewContent->setTemplate('pdf/verify-automobile');
        } else {
            $this->flashMessenger()->addErrorMessage('Code or record number not recognised.');
            return $this->redirect()->toRoute('verify');
        }

        // create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('RepublicOfGoodHope.org');
        $pdf->SetTitle('Verification service');
        $pdf->SetSubject('-');
        $pdf->SetKeywords('-');
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        // set header and footer fonts
        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('dejavusans', '', 10);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Print a table
        // add a page
        $pdf->AddPage();

        $content = $this->renderer->render($viewContent);

        // output the HTML content
        $pdf->writeHTML($content, true, false, true, false, '');

        //Close and output PDF document
        $pdf->Output('RGH-VERIFICATION', 'I');

        exit;
    }

    public function termsAction()
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

    public function contractPdfAction()
    {
        $variable = $this->params()->fromRoute('variable', false);

        if ($variable == 'download') {
        }

        // create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('ClickClouds.net');
        $pdf->SetTitle('ClickClouds - Invoice Generator');
        $pdf->SetSubject('This invoice generated by the ClickClouds affiliate system');
        $pdf->SetKeywords('clickclouds');
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        // set header and footer fonts
        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('dejavusans', '', 10);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Print a table
        // add a page
        $pdf->AddPage();

        // Email content
        $viewContent = new ViewModel(
            [
                'affiliate_business' => '',
                'affiliate_name' => '',
                'affiliate_email' => '',
                'affiliate_tell' => '',
                'affiliate_cell' => '',
                'date' => '',
                'invoice_number' => '',
                'customer_number' => '',
                'street_address' => '',
                'merchant_address' => '',
                'invoice_total' => '',
                'bank_details' => '',
                'instruction' => ''
            ]
        );

        $viewContent->setTemplate('pdf/agreement');
        $content = $this->renderer->render($viewContent);

        // output the HTML content
        $pdf->writeHTML($content, true, false, true, false, '');

        //Close and output PDF document
        $pdf->Output('click_inv_12345', 'I');

        exit;


        die("pdf contract");
    }
}
