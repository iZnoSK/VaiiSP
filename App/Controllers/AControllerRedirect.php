<?php

namespace App\Controllers;

abstract class AControllerRedirect extends \App\Core\AControllerBase
{
    protected function redirect($controller, $action = "", $params = [])
    {
        //príklad -> localhost/Semestralka/?c=home&a=addLike&postid=$post->getId()
        //?c=home
        $location = "Location: ?c=$controller";
        //&a=addLike
        if ($action != "") {
            $location .= "&a=$action";
        }
        //&postid = $post->getId()
        foreach ($params as $name => $value) {
            $location .= "&$name=" . urlencode($value);
        }
        //presmerovanie na inú URL adresu
        header($location);
    }
}