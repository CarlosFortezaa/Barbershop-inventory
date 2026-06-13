<?php
include APP_ROOT . "/views/templates/header.php";
$total_quantity = ProductDB::totalQuantity();
$max_quantity = ProductDB::maxQuantityProduct();
$zero_quantity = ProductDB::zeroStockProduct();
$low_quantity = ProductDB::lowQuantityProduct();
$total_inventory_value = ProductDB::totalInventoryValue();
$lowStockProducts = ProductDB::getLowQuantityProducts();
$movements5 = InventoryDB::get5Movements();
$productsByCategory = ProductDB::getProductsByCategory();
$mostUsedProducts = InventoryDB::getMostUsedProducts();
$leastUsedProducts = InventoryDB::getLeastUsedProducts();
?>

<div class="dashboard">
    <div class="dashboard_container">
        <h1>Dashboard</h1>
        <div class="dashboard_summary_container">
            <div class="dashboard_blocks">
                <div class="dashboard_blocks_info">
                    <div class="dashboard_blocks_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#c9a34e">
                            <path d="M180-80q-24.75 0-42.37-17.63Q120-115.25 120-140v-483q-17-6-28.5-21.39T80-680v-140q0-24.75 17.63-42.38Q115.25-880 140-880h680q24.75 0 42.38 17.62Q880-844.75 880-820v140q0 20.22-11.5 35.61T840-623v483q0 24.75-17.62 42.37Q804.75-80 780-80H180Zm0-540v480h600v-480H180Zm-40-60h680v-140H140v140Zm220 260h240v-60H360v60Zm120 40Z" />
                        </svg>
                    </div>
                    <div class="dashboard_blocks_results">
                        <p class="dashboard_blocks_p">Cantidad total de productos</p>
                        <h1><?= $total_quantity ?></h1>
                    </div>
                </div>
            </div>
            <div class="dashboard_blocks">
                <div class="dashboard_blocks_info">
                    <div class="dashboard_box_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#c9a34e">
                            <path d="M180-80q-24.75 0-42.37-17.63Q120-115.25 120-140v-483q-17-6-28.5-21.39T80-680v-140q0-24.75 17.63-42.38Q115.25-880 140-880h680q24.75 0 42.38 17.62Q880-844.75 880-820v140q0 20.22-11.5 35.61T840-623v483q0 24.75-17.62 42.37Q804.75-80 780-80H180Zm0-540v480h600v-480H180Zm-40-60h680v-140H140v140Zm220 260h240v-60H360v60Zm120 40Z" />
                        </svg>
                    </div>
                    <div class="dashboard_blocks_results">
                        <p class="dashboard_blocks_p">Cantidad mas alta de producto</p>
                        <h1><?= $max_quantity ?></h1>
                    </div>
                </div>
            </div>
            <div class="dashboard_blocks">
                <div class="dashboard_blocks_info">
                    <div class="dashboard_box_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#c9a34e">
                            <path d="M180-80q-24.75 0-42.37-17.63Q120-115.25 120-140v-483q-17-6-28.5-21.39T80-680v-140q0-24.75 17.63-42.38Q115.25-880 140-880h680q24.75 0 42.38 17.62Q880-844.75 880-820v140q0 20.22-11.5 35.61T840-623v483q0 24.75-17.62 42.37Q804.75-80 780-80H180Zm0-540v480h600v-480H180Zm-40-60h680v-140H140v140Zm220 260h240v-60H360v60Zm120 40Z" />
                        </svg>
                    </div>
                    <div class="dashboard_blocks_results">
                        <p class="dashboard_blocks_p">Productos agotados</p>
                        <h1><?= $zero_quantity ?></h1>
                    </div>
                </div>
            </div>
            <div class="dashboard_blocks">
                <div class="dashboard_blocks_info">
                    <div class="dashboard_box_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#c9a34e">
                            <path d="M440-183v-274L200-596v274l240 139Zm80 0 240-139v-274L520-457v274Zm-80 92L160-252q-19-11-29.5-29T120-321v-318q0-22 10.5-40t29.5-29l280-161q19-11 40-11t40 11l280 161q19 11 29.5 29t10.5 40v318q0 22-10.5 40T800-252L520-91q-19 11-40 11t-40-11Zm200-528 77-44-237-137-78 45 238 136Zm-160 93 78-45-237-137-78 45 237 137Z" />
                        </svg>
                    </div>
                    <div class="dashboard_blocks_results">
                        <p class="dashboard_blocks_p">Productos con poca cantidad</p>
                        <h1><?= $low_quantity ?></h1>
                    </div>
                </div>
            </div>
            <div class="dashboard_blocks">
                <div class="dashboard_blocks_info">
                    <div class="dashboard_box_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#c9a34e">
                            <path d="M444-200h70v-50q50-9 86-39t36-89q0-42-24-77t-96-61q-60-20-83-35t-23-41q0-26 18.5-41t53.5-15q32 0 50 15.5t26 38.5l64-26q-11-35-40.5-61T516-710v-50h-70v50q-50 11-78 44t-28 74q0 47 27.5 76t86.5 50q63 23 87.5 41t24.5 47q0 33-23.5 48.5T486-314q-33 0-58.5-20.5T390-396l-66 26q14 48 43.5 77.5T444-252v52Zm36 120q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                        </svg>
                    </div>
                    <div class="dashboard_blocks_results">
                        <p class="dashboard_blocks_p">Valor total del inventario</p>
                        <h1>$<?= $total_inventory_value ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard_statistics_containers">
        <div class="dashboard_container2">
            <div class="dashboard_title">
                <h2>Alertas de bajo stock (Maximo de 5)</h2>
            </div>
            <div class="dashboard_lowstock_container">
                <?php if (!empty($lowStockProducts)) { ?>
                    <table class="dashboard_lowstock_table">
                        <tr>
                            <th class="dashboard_lowstock_th">Producto</th>
                            <th class="dashboard_lowstock_th">Cantidad Actual</th>
                            <th class="dashboard_lowstock_th">Cantidad Minima</th>
                        </tr>
                        <?php foreach ($lowStockProducts as $prod) { ?>
                            <tr>
                                <td><?= $prod['name'] ?></td>
                                <td class="red-text"><?= $prod['quantity'] ?></td>
                                <td><?= $prod['min_stock'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <p>No low stock products</p>
                <?php } ?>
            </div>
        </div>
        <div class="dashboard_container3">
            <div class="dashboard_title">
                <h2>Movimientos mas recientes (Maximo de 5)</h2>
            </div>
            <table class="dashboard_movement_table">
                <tr>
                    <th class="dashboard_lowstock_th">Producto</th>
                    <th class="dashboard_lowstock_th">Tipo</th>
                    <th class="dashboard_lowstock_th">Cantidad</th>
                    <th class="dashboard_lowstock_th">Fecha</th>
                </tr>
                <?php if (!empty($movements5)): ?>
                    <?php foreach ($movements5 as $movement): ?>
                        <tr>
                            <td><?= htmlspecialchars($movement['product_name']) ?></td>
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
            </table>
        </div>

        <div class="dashboard_container2">
            <div class="dashboard_title">
                <h2>Productos por categoría</h2>
            </div>

            <div class="dashboard_lowstock_container">
                <?php if (!empty($productsByCategory)) { ?>
                    <table class="dashboard_lowstock_table">
                        <tr>
                            <th class="dashboard_lowstock_th">Categoría</th>
                            <th class="dashboard_lowstock_th">Cantidad de productos</th>
                        </tr>

                        <?php foreach ($productsByCategory as $row) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row['category']) ?></td>
                                <td><?= htmlspecialchars($row['total_products']) ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <p>No hay categorías registradas.</p>
                <?php } ?>
            </div>
        </div>
        <div class="dashboard_container2">
            <div class="dashboard_title">
                <h2>Productos más usados</h2>
            </div>

            <div class="dashboard_lowstock_container">
                <?php if (!empty($mostUsedProducts)) { ?>
                    <table class="dashboard_lowstock_table">
                        <tr>
                            <th class="dashboard_lowstock_th">Producto</th>
                            <th class="dashboard_lowstock_th">Cantidad usada</th>
                        </tr>

                        <?php foreach ($mostUsedProducts as $prod) { ?>
                            <tr>
                                <td><?= htmlspecialchars($prod['product_name']) ?></td>
                                <td><?= htmlspecialchars($prod['total_used']) ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <p>No hay datos de uso todavía.</p>
                <?php } ?>
            </div>
        </div>

        <div class="dashboard_container2">
            <div class="dashboard_title">
                <h2>Productos menos usados</h2>
            </div>

            <div class="dashboard_lowstock_container">
                <?php if (!empty($leastUsedProducts)) { ?>
                    <table class="dashboard_lowstock_table">
                        <tr>
                            <th class="dashboard_lowstock_th">Producto</th>
                            <th class="dashboard_lowstock_th">Cantidad usada</th>
                        </tr>

                        <?php foreach ($leastUsedProducts as $prod) { ?>
                            <tr>
                                <td><?= htmlspecialchars($prod['product_name']) ?></td>
                                <td><?= htmlspecialchars($prod['total_used']) ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <p>No hay datos de uso todavía.</p>
                <?php } ?>
            </div>
        </div>

        <div class="dashboard_actions_container">
            <div class="dashboard_title">
                <h2>Accesos rápidos</h2>
            </div>
            <div class="dashboard_quick_actions">
                <a class="dashboard_links" href="<?= BASE_URL ?>/index.php?action=product_list"><svg xmlns="http://www.w3.org/2000/svg" height="74x" viewBox="0 -960 960 960" width="74px" fill="#c9a34e">
                        <path d="M180-80q-24.75 0-42.37-17.63Q120-115.25 120-140v-483q-17-6-28.5-21.39T80-680v-140q0-24.75 17.63-42.38Q115.25-880 140-880h680q24.75 0 42.38 17.62Q880-844.75 880-820v140q0 20.22-11.5 35.61T840-623v483q0 24.75-17.62 42.37Q804.75-80 780-80H180Zm0-540v480h600v-480H180Zm-40-60h680v-140H140v140Zm220 260h240v-60H360v60Zm120 40Z" />
                    </svg>Ver productos</a>
                <a class="dashboard_links" href="<?= BASE_URL ?>/index.php?action=create_product"><svg xmlns="http://www.w3.org/2000/svg" height="74px" viewBox="0 -960 960 960" width="74px" fill="#c9a34e">
                        <path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                    </svg>Crear producto</a>
                <a class="dashboard_links" href="<?= BASE_URL ?>/index.php?action=inventory_movements"><svg xmlns="http://www.w3.org/2000/svg" height="74px" viewBox="0 -960 960 960" width="74px" fill="#c9a34e">
                        <path d="M280-160 80-360l200-200 56 57-103 103h287v80H233l103 103-56 57Zm400-240-56-57 103-103H440v-80h287L624-743l56-57 200 200-200 200Z" />
                    </svg>Ver movimientos</a>
            </div>
        </div>
    </div>
</div>
<?php include APP_ROOT . '/views/templates/footer.php';
