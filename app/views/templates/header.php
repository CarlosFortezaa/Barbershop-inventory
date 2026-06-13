<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sistema de manejo de inventario</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=attach_money" />
</head>

<body>
    <?php if (!empty($_SESSION['user'])) { ?>
        <header>
            <a href="<?= BASE_URL ?>/index.php?action=dashboard">
                <img class="logo" src="<?= BASE_URL ?>/images/logo.png?v=<?= time() ?>" alt="Mustach Barber Shop Logo">
            </a>
            <nav style="float:left; margin-left:40px;">
                <a href="<?= BASE_URL ?>/index.php?action=dashboard" class="<?= ($action === 'dashboard') ? 'active' : '' ?>">Dashboard</a>
                <a href="<?= BASE_URL ?>/index.php?action=product_list" class="<?= ($action === 'product_list') ? 'active' : '' ?>">Productos</a>
                <a href="<?= BASE_URL ?>/index.php?action=create_product" class="<?= ($action === 'create_product') ? 'active' : '' ?>">Crear Producto</a>
                <!-- <a href="<?= BASE_URL ?>/index.php?action=subscriptions_list"class="<?= ($action === 'subscriptions_list') ? 'active' : '' ?>">Lista de E-mails</a> -->
                <a href="<?= BASE_URL ?>/index.php?action=inventory_movements" class="<?= ($action === 'inventory_movements') ? 'active' : '' ?>">Movimientos de Productos</a>

                <!-- el ciclo if verifica si hay session y si el rol es admin parar mostrar diferentes encabezados
                <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') { ?>
                    <a href="<?= BASE_URL ?>/index.php?action=register" class="<?= ($action === 'register') ? 'active' : '' ?>">Crear Cuentas</a>
                    <a href="<?= BASE_URL ?>/index.php?action=manage_users" class="<?= ($action === 'manage_users') ? 'active' : '' ?>">Manejar Cuentas</a>
                <?php } ?> -->
            <?php } ?>
            </nav>
            <div class="nav-right">
                <?php if (!empty($_SESSION['user'])) { ?>

                    Hola, <?= htmlspecialchars($_SESSION['user']['id']) ?>
                    |
                    <a class="logout-link" href="<?= BASE_URL ?>/index.php?action=logout">Logout</a>
                <?php } ?>
            </div>
        </header>

        <main>