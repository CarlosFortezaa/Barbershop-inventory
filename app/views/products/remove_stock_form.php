<?php
include APP_ROOT . '/views/templates/header.php'; ?>

<?php if (!empty($errores)){ ?>
    <div class="errors">
        <ul>
            <?php foreach ($errores as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>


<h2>Quitar Stock</h2>

<form action="index.php?action=remove_stock&prod_id=<?= $product->getProdId() ?>" method="post">
    <p>Producto: <?= htmlspecialchars($product->getName()) ?></p>
    <p>Cantidad Actual: <?= htmlspecialchars($product->getQuantity()) ?></p>

    <label for="quantity_change">Cantidad a quitar: </label>
    <input type="number" name="quantity_change" min="1" required>

    <button type="submit">Quitar</button>
</form>

<a href="index.php?action=product_list">Volver</a>

<?php include APP_ROOT . '/views/templates/footer.php' ?>