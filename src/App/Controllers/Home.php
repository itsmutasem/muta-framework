<?php

namespace App\Controllers;
use Framework\Controller;
use Framework\Viewer;

class Home extends Controller
{
    public function index()
    {
        $viewer = new Viewer();
        echo $viewer->render("shared/header", ["title" => "Home"]);
        echo $viewer->render("Home/index");
    }
}
