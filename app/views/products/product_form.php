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

<form action="index.php?action=create_product" method="post" enctype="multipart/form-data"> <!-- enctype es para poder subir archivos -->
    <legend>Añade tu Producto</legend>
    <label for="image">Foto del producto: </label>
    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
    <label for="name">Nombre: </label>
    <input type="text" id="name" name="name" value="<?= $_POST['name'] ?? ''; ?>">

    <label for="category">Categoria: </label>
    <select name="category" id="category">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
    </select>

    <label for="quantity">Cantidad: </label>
    <input type="number" id="quantity" name="quantity" min="1" value="<?= $_POST['quantity'] ?? ''; ?>">

    <label for="min_stock">Cantidad Minima: </label>
    <input type="number" id="min_stock" name="min_stock" min="1" value="<?= $_POST['min_stock'] ?? ''; ?>">

    <label for="price">Precio</label>
    <input type="number" id="price" name="price" min="1" step="0.01" value="<?= $_POST['price'] ?? ''; ?>">


    <label for="created_at">Dia de Creacion: </label>
    <input type="date" id="created_at" name="created_at" value="<?= $_POST['created_at'] ?? date('Y-m-d'); ?>" readonly> <!-- read only para que no puedan cambiar el dia de publicacion -->
<br><br>
    <input class="submit" type="submit" value="Crear Producto">
</form>