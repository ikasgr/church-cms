<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('frontend/home', [
            'title' => 'CMS Church || Responsive HTML 5 Template',
        ]);
    }
}
