<div class="list-group">
    <a class="list-group-item text-center active" data-remote="true" href="#" id="categoria_0">
        Categorías
    </a>
    <?php foreach ($categorias as $categoria) : ?>
    <a class="list-group-item" data-remote="true" href="#" style="padding-left: 25px;">
        <span class="fa <?= $categoria->getIcon() ?> fa-tree fa-lg fa-fw"></span>
        <span style="margin-left: 25px;"><?= $categoria->getNombre() ?></span>
    </a>
    <?php endforeach ?>
</div>