<?php

namespace App\Controllers;
use Framework\Controller;
use Framework\PHPTemplateViewer;

class Home extends Controller
{
    public function index()
    {
        echo $this->viewer->render("shared/header", ["title" => "Home"]);
        echo $this->viewer->render("Home/index");
    }
}
