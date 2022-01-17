<?php

namespace App\Controllers;

/**
 * Trieda reprezentuje kontroler, pomocou ktorého sa dá jednoducho presmerovať na inú URL adresu
 * @package App\Controllers
 */
abstract class AControllerRedirect extends \App\Core\AControllerBase
{
    protected function redirect($controller, $action = "", $params = [])
    {
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
        //presmerovanie na danú URL adresu
        header($location);
    }
}