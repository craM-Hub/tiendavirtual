<?php

namespace ProyectoWeb\app\controllers;

use Psr\Container\ContainerInterface;
use ProyectoWeb\exceptions\NotFoundException;
use ProyectoWeb\repository\CategoryRepository;
use ProyectoWeb\repository\ProductRepository;

class CategoryController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listado($request, $response, $args)
    {
        extract($args);

        $repositorio = new CategoryRepository();
        try {
            //ver NOTA
            $categoriaActual = $repositorio->findById($id);
        } catch (NotFoundException $nfe) {
            return $response->write("Categoria no encontrada");
        }
        $title = $categoriaActual->getNombre();
        $repositorioProductos = new ProductRepository();
        $productos = $repositorioProductos->getByCategory($categoriaActual->getId());
        $categorias = $repositorio->findAll();

        return $this->container->renderer->render(
            $response,
            "categoria.view.php",
            compact('title', 'categorias', 'categoriaActual', 'productos')
        );
    }
}