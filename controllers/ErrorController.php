<?php

namespace mimilun\controllers;


class ErrorController extends BaseController
{
    public function error(): void
    {
        $this->view->renderHtml('404.php');
    }
}