<?php

namespace ProyectoWeb\app\controllers;

use Psr\Container\ContainerInterface;
use ProyectoWeb\exceptions\NotFoundException;
use ProyectoWeb\repository\CategoryRepository;
use ProyectoWeb\repository\ProductRepository;

class ProductController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function ficha($request, $response, $args)
    {
        extract($args);
        $repositorioCateg = new CategoryRepository();
        $categorias = $repositorioCateg->findAll();
        $repositorio = new ProductRepository();
        try {
            $producto = $repositorio->findById($id);
        } catch (NotFoundException $nfe) {
            $response = new \Slim\Http\Response(404);
            return $response->write("Producto no encontrado");
        }
        $title = $producto->getNombre();
        $relacionados = $repositorio->getRelacionados($producto->getId(), $producto->getIdCategoria());
        return $this->container->renderer->render(
            $response,
            "product.view.php",
            compact('title', 'categorias', 'producto', 'relacionados')
        );
    }
}