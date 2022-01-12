<?php

namespace ProyectoWeb\app\controllers;

use Psr\Container\ContainerInterface;
use ProyectoWeb\entity\Product;
use ProyectoWeb\exceptions\QueryException;
use ProyectoWeb\exceptions\NotFoundException;
use ProyectoWeb\database\Connection;
use ProyectoWeb\repository\ProductRepository;
use ProyectoWeb\core\App;

class CartController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function render($request, $response, $args)
    {
        extract($args);
        $title = " Carrito ";
        $withCategories = false;
        //obtener productos del carro
        $repositorio = new ProductRepository;
        $productos = $repositorio->getFromCart($this->container->cart);

        return $this->container->renderer->render($response, "cart.view.php", compact('title', 'withCategories', 'productos'));
    }

    public function add($request, $response, $args)
    {
        extract($args);
        $quantity = ($quantity ?? 1);
        $respitorio = new ProductRepository;
        try {
            $producto = $respitorio->findById($id);
            $this->container->cart->addItem($id, $quantity);
        } catch (NotFoundException $nfe) {;
        }
        return $response->withRedirect($this->container->router->pathFor('cart'), 303);
    }

    public function empty($request, $response, $args)
    {
        extract($args);
        $this->container['cart']->empty();
        return $response->withRedirect($this->container->router->pathFor('cart'), 303);
    }

    public function delete($request, $response, $args)
    {
        extract($args);
        $this->container['cart']->deleteItem($id);
        return $response->withRedirect($this->container->router->pathFor('cart'), 303);
    }
}