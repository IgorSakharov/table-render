<?php
namespace Src\Controllers;

use Src\Forms\TableForm;
use Src\Services\TableRenderService;
use Vendor\Form\BaseForm;
use Vendor\Request\Request;
use Vendor\Response\Response;
use Vendor\ViewCreator\View;

/**
 * Class IndexController
 * @package Src\Controllers
 */
class IndexController
{
    /**
     * @var TableRenderService
     */
    protected $tableRender;

    /**
     * @var View
     */
    protected $view;

    /**
     * IndexController constructor.
     */
    public function __construct()
    {
        $this->view        = new View();
        $this->tableRender = new TableRenderService();
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        return new Response(
            $this->view->render('index.html', [
                'hello' => 'test'
            ])
        );
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function handelForm(Request $request)
    {
        $form = new BaseForm($request, new TableForm());
        var_dump($form->getDataByName('text'));
        die;
    }
}