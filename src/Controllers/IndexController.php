<?php
namespace Src\Controllers;

use Src\Services\TableRenderService;
use Vendor\Request\Request;
use Vendor\Response\Response;
use Vendor\ViewCreator\View;

/**
 * Class IndexController
 *
 * @package Src\Controllers
 */
class IndexController
{
    /**
     * @var View
     */
    protected $view;

    /**
     * IndexController constructor.
     *
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @param Request            $request
     * @param TableRenderService $tableRenderService
     *
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request, TableRenderService $tableRenderService)
    {
        return new Response(
            $this->view->render('base.html', [
                'table' => $tableRenderService->createNewTable(),
                'title' => 'TITLE FOR THIS PAGE'
            ])
        );
    }
}