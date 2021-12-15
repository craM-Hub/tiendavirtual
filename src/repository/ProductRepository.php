<?php
namespace ProyectoWeb\repository;

use ProyectoWeb\database\QueryBuilder;


class ProductRepository extends QueryBuilder
{
    public function __construct(){
        parent::__construct('productos', 'Product');
    }
}