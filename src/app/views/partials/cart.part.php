<div class="row carro">
    <h2 class="subtitle" style="margin:0;">Carrito de la compra</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($cart->isEmpty()) : ?>
            <tr>
                <td colspan='6'>
                    <div class='alert alert-danger'>Su carro está vacío.</div>
                </td>
            </tr>
            <?php else : ?>
            <?php $i = 1;
                $total = 0;
                foreach ($productos as $producto) :
                    $total += $cart->getCart()[$producto->getId()] * $producto->getPrecio();
                ?>
            <td><a href="<?= $router->pathFor('cart-delete', ['id' => $producto->getId()]) ?>"
                    onclick="return confirmDeleteItem();"><span class='fa fa-close'></span></a></td>
            <tr>
                <th scope="row"><?= $i++; ?></th>
                <td><a
                        href="<?= $router->pathFor('ficha', ['nombre' =>  ProyectoWeb\app\utils\Utils::encodeURI($producto->getNombre()), 'id' => $producto->getId()]) ?>"><?= $producto->getNombre() ?></a>
                </td>
                <td><?= number_format($producto->getPrecio(), 2, ',', ' ') ?> </td>
                <td><?= $cart->getCart()[$producto->getId()] ?></td>
                <td><?= number_format($cart->getCart()[$producto->getId()] * $producto->getPrecio(), 2, ',', ' '); ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align:right;">
                    <b>Total: <?= number_format($total, 2, ',', ' ') ?> </b>
                </td>
            </tr>
            <tr>
                <td colspan="3"><a class="btn btn-danger" href="#">Finalizar compra</a></td>
                <td colspan="2"><a class="btn btn-danger" href="<?= $router->pathFor('cart-empty') ?>"
                        onclick="return confirmEmptyCart();">Vaciar
                        Carrito</a></td>
            </tr>
        </tfoot>
        <?php endif ?>
    </table>
</div>