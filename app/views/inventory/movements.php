<?php include APP_ROOT . '/views/templates/header.php'; ?>

<h1>Movimientos de Inventario</h1>

<form method="get" action="<?= BASE_URL ?>/index.php" class="search-bar">
    <input type="hidden" name="action" value="inventory_movements">

    <select name="product_id" id="product_id">
        <option value="">Todos los productos</option>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <option value="<?= htmlspecialchars($product->getProdId()) ?>"
                    <?= (($product_id ?? '') == $product->getProdId()) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($product->getName()) ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>

    <select name="category" id="category">
        <option value="">Todas las categorías</option>
        <?php for ($i = 1; $i <= 7; $i++): ?>
            <option value="<?= $i ?>" <?= (($category ?? '') == $i) ? 'selected' : '' ?>>
                Categoría <?= $i ?>
            </option>
        <?php endfor; ?>
    </select>

    <input 
        type="date" 
        name="movement_date" 
        id="movement_date"
        value="<?= htmlspecialchars($movement_date ?? '') ?>">

    <button class="submit" type="submit">Filtrar</button>

    <a class="submit" href="<?= BASE_URL ?>/index.php?action=inventory_movements">Limpiar</a>
</form>

<h2>Historial de Movimientos</h2>

<table>
    <thead>
    <tr>
        <th>Producto</th>
        <th>Categoría</th>
        <th>Tipo</th>
        <th>Cantidad</th>
        <th>Fecha</th>
   </tr>
    </thead>
    <tbody>
        <?php if (!empty($movements)): ?>
            <?php foreach ($movements as $movement): ?>
        <tr>
              <td><?= htmlspecialchars($movement['product_name']) ?></td>
              <td><?= htmlspecialchars($movement['product_category']) ?></td>
          <td>
           <span class="movement-badge uppercase <?= $movement['movement_type'] === 'restock' ? 'badge-restock' : 'badge-usage' ?>">
             <?= htmlspecialchars($movement['movement_type']) ?>
           </span>
          </td>
          <td><?= htmlspecialchars($movement['quantity_change']) ?></td>
          <td><?= htmlspecialchars($movement['timestamp']) ?></td>
     </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="no-results">No hay movimientos registrados.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include APP_ROOT . '/views/templates/footer.php'; ?>