<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 11/24/2017
 * Time: 11:53 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class LuckyController
{
    /**
     * @Route("/lucky")
     */
    public function numberAction()
    {
        return new Response('You are lucky boy');
//        $number = mt_rand(0, 100);
//
//        return new Response(
//            '<html><body>Lucky number: '.$number.'</body></html>'
//        );
    }
}