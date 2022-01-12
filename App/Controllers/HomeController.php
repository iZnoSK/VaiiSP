<?php

namespace App\Controllers;

use App\Core\AControllerBase;

/**
 * Class HomeController
 * Example of simple controller
 * @package App\Controllers
 */
class HomeController extends AControllerRedirect
{
    public function index()
    {
        return $this->html(
            [
                'meno' => 'študent'
            ]);
    }
}