<?php
include APP_ROOT . "/views/templates/header.php";
?>

<h2>Lista de Productos</h2>

<?php if (!empty($_SESSION['success'])) { ?>
    <div class="success">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php } else  if (!empty($errores)) { ?>
    <div class="errors">
        <ul>
            <?php foreach ($errores as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>

<!-- SEARCH BAR -->
<!-- Formulario que envia el termino de busqueda preservando el filtro de vencidas si esta activo -->
<form method="get" action="<?= BASE_URL ?>/index.php" class="search-bar">
    <input type="hidden" name="action" value="product_list">

    <select name="category">
        <option value="">Todas las categorías</option>
        <option value="1" <?= (($category ?? '') === '1') ? 'selected' : '' ?>>Categoría 1</option>
        <option value="2" <?= (($category ?? '') === '2') ? 'selected' : '' ?>>Categoría 2</option>
        <option value="3" <?= (($category ?? '') === '3') ? 'selected' : '' ?>>Categoría 3</option>
        <option value="4" <?= (($category ?? '') === '4') ? 'selected' : '' ?>>Categoría 4</option>
        <option value="5" <?= (($category ?? '') === '5') ? 'selected' : '' ?>>Categoría 5</option>
        <option value="6" <?= (($category ?? '') === '6') ? 'selected' : '' ?>>Categoría 6</option>
        <option value="7" <?= (($category ?? '') === '7') ? 'selected' : '' ?>>Categoría 7</option>
    </select>

    <input
        type="text"
        name="search"
        placeholder="Buscar productos..."
        value="<?= htmlspecialchars($search ?? '') ?>">

    <button class="submit" type="submit">Buscar</button>
    <a class="submit" href="<?= BASE_URL ?>/index.php?action=product_list">Limpiar</a>
</form>


<!-- TABLA DE RESULTADOS -->
<!-- Si hay oportunidades para mostrar, las desplegamos en una tabla -->
<?php if (!empty($products)) { ?>
    <div class="product_card">
        <?php foreach ($products as $prod) { ?>
            <div class="product_cards">
                <div class="product_card_header">
                    <div class="product_card_header_name">
                        <h2><?= htmlspecialchars($prod->getName()); ?></h2>
                    </div>
                    <div class="product_card_header_alert <?= ($prod->getQuantity() < $prod->getMinStock()) ? 'bg-red' : (($prod->getQuantity() < $prod->getMinStock() * 2) ? 'bg-yellow' : 'bg-green'); ?>">
                        <div class="alert_icon">
                            <?php if ($prod->getQuantity() == 0) { ?>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ff5a5f">
                                    <path d="M440-280h80v-240h-80v240Zm68.5-331.5Q520-623 520-640t-11.5-28.5Q497-680 480-680t-28.5 11.5Q440-657 440-640t11.5 28.5Q463-600 480-600t28.5-11.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                </svg>
                                <span>Agotado!</span>
                            <?php } else if ($prod->getQuantity() < $prod->getMinStock()) { ?>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ff5a5f">
                                    <path d="M440-280h80v-240h-80v240Zm68.5-331.5Q520-623 520-640t-11.5-28.5Q497-680 480-680t-28.5 11.5Q440-657 440-640t11.5 28.5Q463-600 480-600t28.5-11.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                </svg>
                                <span>Bajo stock</span>
                            <?php } else if ($prod->getQuantity() < $prod->getMinStock() * 2) { ?>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e7c36a">
                                    <path d="M440-280h80v-240h-80v240Zm68.5-331.5Q520-623 520-640t-11.5-28.5Q497-680 480-680t-28.5 11.5Q440-657 440-640t11.5 28.5Q463-600 480-600t28.5-11.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                </svg>
                                <span>Medio Stock</span>
                            <?php } else { ?>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#49d17d">
                                    <path d="M440-280h80v-240h-80v240Zm68.5-331.5Q520-623 520-640t-11.5-28.5Q497-680 480-680t-28.5 11.5Q440-657 440-640t11.5 28.5Q463-600 480-600t28.5-11.5ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                </svg>
                                <span>Alto stock</span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="product_card_image">
                    <?php if (!empty($prod->getImagePath())) { ?>
                        <img src="<?= BASE_URL . '/' . htmlspecialchars($prod->getImagePath()) ?>" alt="<?= htmlspecialchars($prod->getName()) ?>">
                    <?php } else { ?>
                        <div class="product_card_image_placeholder">Sin imagen</div>
                    <?php } ?>
                </div>
                <div class="product_card_main_info">
                    <div class="product_card_main_info_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#c9a34e">
                            <path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z" />
                        </svg>
                        <h3 class="white">Categoria <br><span class="gold"><?= htmlspecialchars($prod->getCategory()) ?></span></h3>
                    </div>
                    <div class="product_card_main_info_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#c9a34e">
                            <path d="M200-80q-33 0-56.5-23.5T120-160v-451q-18-11-29-28.5T80-680v-120q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v120q0 23-11 40.5T840-611v451q0 33-23.5 56.5T760-80H200Zm0-520v440h560v-440H200Zm-40-80h640v-120H160v120Zm200 280h240v-80H360v80Zm120 20Z" />
                        </svg>
                        <h3 class="white">Stock <br><span class="<?= ($prod->getQuantity() < $prod->getMinStock()) ? 'red-text' : (($prod->getQuantity() < $prod->getMinStock() * 2) ? 'yellow-text' : 'green-text') ?>"><?= htmlspecialchars($prod->getQuantity()) ?> / <?= $prod->getMinStock() ?></span></h3>
                    </div>

                    <div class="product_card_main_info_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#c9a34e">
                            <path d="M444-200h70v-50q50-9 86-39t36-89q0-42-24-77t-96-61q-60-20-83-35t-23-41q0-26 18.5-41t53.5-15q32 0 50 15.5t26 38.5l64-26q-11-35-40.5-61T516-710v-50h-70v50q-50 11-78 44t-28 74q0 47 27.5 76t86.5 50q63 23 87.5 41t24.5 47q0 33-23.5 48.5T486-314q-33 0-58.5-20.5T390-396l-66 26q14 48 43.5 77.5T444-252v52Zm36 120q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                        </svg>
                        <h3 class="white">Precio <br><span class="gold">$<?= $prod->getPrice() ?></span></h3>
                    </div>
                </div>
                <div class="product_card_footer">
                    <div class="product_card_footer_buttons">
                        <a class="boton-editar" href="<?= BASE_URL ?>/index.php?action=edit_product&prod_id=<?= $prod->getProdId() ?>">Editar</a>
                        <a class="boton-eliminar" href="<?= BASE_URL ?>/index.php?action=delete_product&prod_id=<?= $prod->getProdId() ?>"
                            onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
                        <a class="botones-restock" href="<?= BASE_URL ?>/index.php?action=remove_stock&prod_id=<?= $prod->getProdId() ?>"> - Quitar</a>
                        <a class="botones-restock" href="<?= BASE_URL ?>/index.php?action=add_stock&prod_id=<?= $prod->getProdId() ?>"> + Anadir</a>
                    </div>
                    <div class="product_card_footer_date">
                        <h3><?= $prod->getCreatedAt() ?></h3>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>


    <!-- Si no hay oportunidades, mostramos mensaje informativo -->
<?php } else { ?>
    <div class="no-results">
        <p>No se encontraron productos.</p>
    </div>
<?php } ?>

<!-- Boton para crear nueva oportunidad, visible solo para usuarios autenticados -->
<!-- <br>
<?php if (!empty($_SESSION['user'])) { ?>
    <p>
        <a class="submit" href="<?= BASE_URL ?>/index.php?action=create_product">Crear Producto</a>
    </p>
<?php } ?> -->

<?php include APP_ROOT . "/views/templates/footer.php"; ?>