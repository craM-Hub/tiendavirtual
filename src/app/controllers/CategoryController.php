<?php

namespace ProyectoWeb\app\controllers;

use ProyectoWeb\core\App;
use Psr\Container\ContainerInterface;
use ProyectoWeb\exceptions\NotFoundException;
use ProyectoWeb\repository\CategoryRepository;
use ProyectoWeb\repository\ProductRepository;
use JasonGrimes\Paginator;

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
            $categoriaActual = $repositorio->findById($id);
        } catch (NotFoundException $nfe) {
            return $response->write("Categoria no encontrada");
        }
        $title = $categoriaActual->getNombre();
        $currentPage = ($currentPage ?? 1);
        $repositorioProductos = new ProductRepository();
        $totalItems = $repositorioProductos->getCountByCategory($categoriaActual->getId());
        $itemsPerPage = App::get('config')['itemsPerPage'];
        $productos = $repositorioProductos->getByCategory($categoriaActual->getId(), $itemsPerPage, $currentPage);
        $categorias = $repositorio->findAll();
        $urlPattern = $this->container->router->pathFor(
            'categoria',
            [
                'nombre' => \ProyectoWeb\app\utils\Utils::encodeURI($categoriaActual->getNombre()),
                'id' => $categoriaActual->getId()
            ]
        ) . '/page/(:num)';
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);

        return $this->container->renderer->render(
            $response,
            "categoria.view.php",
            compact('title', 'categorias', 'categoriaActual', 'productos', 'paginator')
        );
    }
}