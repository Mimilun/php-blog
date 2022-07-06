<?php

namespace mimilun\controllers;

class MainController extends BaseController
{
    public function main(): void
    {
        $this->view->renderHtml('main/main.php');
    }

    public function about(): void
    {
        $this->view->renderHtml('about/about.php');
    }

    public function contacts(): void
    {
        $this->view->renderHtml('contacts/contacts.php');
    }
}