<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 12/2/2017
 * Time: 2:45 PM
 */
class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'home'));

        $menu->addChild('Book List', array('route' => 'book_list'));

        return $menu;
    }

}