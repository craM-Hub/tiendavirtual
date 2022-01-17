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
        $header = "Carrito de la compra";
        $checkout = false;
        $withCategories = false;
        //obtener productos del carro
        $repositorio = new ProductRepository;
        $productos = $repositorio->getFromCart($this->container->cart);

        return $this->container->renderer->render($response, "cart.view.php", compact('title', 'header', 'checkout', 'withCategories', 'productos'));
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
    public function checkout($request, $response, $args)
    {
        if (!isset($_SESSION['username'])) {
            return $response->withRedirect($this->container->router->pathFor('login') .
                "?returnToUrl=" . $this->container->router->pathFor('cart-checkout'), 303);
        }
        extract($args);
        $title = " Finalizar compra ";
        $header = "Pago con PayPal";
        $withCategories = false;
        $checkout = true;
        //Obtener los productos del carro;
        $repositorio = new ProductRepository;
        $productos = $repositorio->getFromCart($this->container->cart);
        return $this->container->renderer->render(
            $response,
            "cart.view.php",
            compact('title', 'header', 'checkout', 'withCategories', 'productos')
        );
    }
    public function thankyou($request, $response, $args)
    {
        $title = " Finalizar compra ";
        $withCategories = false;
        $this->container['cart']->empty();
        return $this->container->renderer->render(
            $response,
            "thankyou.view.php",
            compact('title', 'withCategories')
        );
    }
}