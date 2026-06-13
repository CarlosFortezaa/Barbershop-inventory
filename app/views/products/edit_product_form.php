<?php include APP_ROOT . '/views/templates/header.php'; ?>

<?php if (!empty($errores)){ ?>
    <div class="errors">
        <ul>
            <?php foreach ($errores as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php if (!empty($product->getImagePath())): ?>
    <p>Imagen actual:</p>
    <img src="<?= BASE_URL . '/' . htmlspecialchars($product->getImagePath()) ?>" alt="Imagen del producto" style="max-width:120px; border-radius:8px; margin-bottom:10px;">
<?php endif; ?>


<form action="index.php?action=edit_product&prod_id=<?= $product->getProdId(); ?>" method="post" enctype="multipart/form-data"> <!-- enctype es para poder subir archivos -->
    <legend>Edita tu Producto</legend>

    <input type="hidden" name="prod_id" value="<?= $product->getProdId() ?>">


    <label for="name">Nombre: </label>
    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product->getName())?>">
    <label for="image">Cambiar foto del producto: </label>
    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
 
    <label for="category">Categoria: </label>
    <select name="category" id="category" value="">
        <?php $currentCategory =  $product->getCategory(); ?>
        <option value="1" <?= $currentCategory === '1' ? 'selected' : '';?>>1</option>
        <option value="2" <?= $currentCategory === '2' ? 'selected' : '' ?>>2</option>
        <option value="3" <?= $currentCategory === '3' ? 'selected' : '' ?>>3</option>
        <option value="4" <?= $currentCategory === '4' ? 'selected' : '' ?>>4</option>
        <option value="5" <?= $currentCategory === '5' ? 'selected' : '' ?>>5</option>
        <option value="6" <?= $currentCategory === '6' ? 'selected' : '' ?>>6</option>
        <option value="7" <?= $currentCategory === '7' ? 'selected' : '' ?>>7</option>
    </select>


    <label for="min_stock">Cantidad Minima: </label>
    <input type="number" id="min_stock" name="min_stock" value="<?= htmlspecialchars($product->getMinStock())?>">

    <label for="price">Precio: </label>
    <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product->getPrice())?>">

<br><br>
    <input class="submit" type="submit" value="Actualizar Producto">
</form>

