<?php
/* EN LUGARES DONDE SE USA ALGO PARECIDO A ESTO: "/index.php?c=product&a=index"
POR EL MOMENTO SE VA A PONER ASI: "/index.php?action=index" EL ACTION UNO LO DEFINE
POR EJEMPLO COMO AQUI: <form action="index.php?action=create_product" method="post" enctype="multipart/form-data"> <!-- enctype es para poder subir archivos --> */
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../public/PHPMailer/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../public/PHPMailer/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../public/PHPMailer/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../app/config/config.php';
require_once APP_ROOT . '/config/database.php';
require_once APP_ROOT . '/models/user.php';
require_once APP_ROOT . '/models/product.php';
require_once APP_ROOT . '/models/UserDB.php';
require_once APP_ROOT . '/models/ProductsDB.php';
require_once APP_ROOT . '/models/Subscription.php';
require_once APP_ROOT . '/models/inventory.php';
require_once APP_ROOT . '/models/InventoryDB.php';




$action = filter_input(INPUT_POST, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = '';
    }
}



switch ($action) {


    //====================================================================== \\
    //                          REGISTER                                     \\
    //====================================================================== \\
    // case 'register':
    //     if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    //         header("Location: index.php?action=product_list");
    //         exit;
    //     }

    //     $errores = []; // para mostrar los mensajes de errores adecuados. solo lo pongo al momento porsiacaso pero no he hecho nada relacionado con los errores
    //     $success = '';

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $user_id = trim($_POST['user_id'] ?? '');
    //         $email = trim($_POST['email']);
    //         $password = trim($_POST['password']);
    //         $role = $_POST['role'] ?? 'contributor'; // si no es admin, es contributor. lo puse asi para que por si pasa algun error, el user siempre tenga un rol por default, en este caso default -> contributor

    //         // Validaciones
    //         if (!preg_match('/^(?=.*[a-z]\.[a-z])[a-z0-9.]+$/', $user_id)) { // solo permite minusculas, numeros y puntos(.) y asegura que haya almenos un punto con letras a ambos lados
    //             $errores[] .= "Formato incorrecto usado. Ejemplo: john.doe";
    //         }

    //         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //             $errores[] .= "Email invalido.";
    //         }

    //         if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*(\d|[^A-Za-z0-9])).{8,}$/', $password)) { // al menos una minuscula, al menos una mayuscula, almenos un numero o simbolo y minimo 8 caracteres
    //             $errores[] .= "El password debe tener almenos 8 caracteres e incluir mayusculas, minusculas y un numero o simbolo.";
    //         }

    //         if (!$errores) {
    //             $password_hash = password_hash($password, PASSWORD_DEFAULT);

    //             // Crear el usuario en la db
    //             $newUser = new User($user_id, $password_hash, $role, $email);
    //             if (!userDB::create_user($newUser)) {
    //                 $errores[] .= "El usuario o correo ya existe.";
    //                 include APP_ROOT . '/views/auth/register.php';
    //                 exit;
    //             } else {
    //                 $_SESSION['success'] = "Usuario '$user_id' creado exitosamente!";
    //                 header("Location: index.php?action=manage_users");
    //                 exit;
    //             }
    //         }
    //     }
    //     include APP_ROOT . '/views/auth/register.php';
    //     break;


    //====================================================================== \\
    //                          LOGIN                                        \\
    //====================================================================== \\
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = trim($_POST['user_id']);
            $password = trim($_POST['password']);
            $user = userDB::findByUserId($user_id);

            if ($user && password_verify($password, $user->getPasswordHash())) {
                $_SESSION['user'] = [
                    'id' => $user->getUserId(),
                ];
                header("Location: index.php?action=dashboard");
                exit; // despues del redirect no se ejecuta codigo adicional
            } else {
                $errores[] = "Credenciales Incorrectos";
            }
        }
        include APP_ROOT . '/views/auth/login.php';
        break;


    //====================================================================== \\
    //                          LOGOUT                                       \\
    //====================================================================== \\
    case 'logout':
        unset($_SESSION['user']);
        session_destroy();
        header('Location: index.php?action=product_list'); // maybe dejarlo en el home como tal no el login? solo una idea idk
        exit;
        break;


    //====================================================================== \\
    //                          MANAGE_USERS                                  \\
    //====================================================================== \\
    // case 'manage_users':
    //     // verifica si el usuario es admin si no es asi lo devuelve al login
    //     if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    //         header("Location: index.php?action=product_list");
    //         exit;
    //     }
    //     // obtiene llos usarios
    //     $users = UserDB::get_users();
    //     // carga el layout de manage.php
    //     include APP_ROOT . '/views/users/manage.php';
    //     break;


    // // se define la accion edit o edit_user para editar un usuario
    // // si es admin permite editar usuarios
    // case 'edit_user_form':
    //     if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    //         header("Location: index.php?action=product_list");
    //         exit;
    //     }

    //     $user_id = $_GET['id'] ?? null;
    //     // verifica que el user id no este vacio y que exista el usuario
    //     if (!$user_id) {
    //         die("User ID faltante");
    //     }

    //     $user = UserDB::findByUserId($user_id);

    //     if (!$user) {
    //         die("Usuario no encontrado");
    //     }
    //     // si todo esta bien muestra edit.php
    //     include APP_ROOT . '/views/users/edit.php';
    //     break;


    //====================================================================== \\
    //                          UPDATE_USER                                   \\
    //====================================================================== \\

    // case 'update_user':
    //     $users = [];
    //     $errores = [];
    //     // si el usuario es admin permite  
    //     if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    //         header("Location: index.php?action=product_list");
    //         exit;
    //     }

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $user_id = $_POST['user_id'];
    //         $email = trim($_POST['email']);
    //         $role = $_POST['role'];
    //         $password = trim($_POST['password']);

    //         $user = UserDB::findByUserId($user_id);

    //         // validar email repetido
    //         $emailExistente = UserDB::findByEmail($email);

    //         // si el email existe y NO es el mismo usuario -> error
    //         if ($emailExistente && $emailExistente->getUserId() !== $user_id) {
    //             $errores[] = "El correo ya está en uso.";
    //         }

    //         $user->setEmail($email);
    //         $user->setRole($role);

    //         // si password no fue cambiado, se queda igual
    //         if (!empty($password)) {
    //             if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*(\d|[^A-Za-z0-9])).{8,}$/', $password)) { // al menos una minuscula, al menos una mayuscula, almenos un numero o simbolo y minimo 8 caracteres
    //                 $errores[] = "El password debe tener almenos 8 caracteres e incluir mayusculas, minusculas y un numero o simbolo.";
    //             } else {
    //                 $password_hash = password_hash($password, PASSWORD_DEFAULT);
    //                 $user->setPasswordHash($password_hash);
    //             }
    //         } else {
    //             $password_hash = null;
    //         }

    //         if ($errores) {
    //             include APP_ROOT . '/views/users/edit.php';
    //             break;
    //         }

    //         UserDB::update_user($user);

    //         $_SESSION['success'] = "Perfil '$user_id' actualizado exitosamente.";
    //         header("Location: index.php?action=manage_users");
    //         exit;
    //     }
    //     break;


    //====================================================================== \\
    //                          DELETE_USER                                   \\
    //====================================================================== \\
    //primero se verifica que el usuario sea admin para que pueda borrar usuarios
    //(medio redundante?)
    // case 'delete_user':
    //     if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    //         header("Location: index.php?action=product_list");
    //         exit;
    //     }

    //     $user_id = $_GET['id'] ?? null;
    //     //si el user id no esta vacio borra el usuario (aunque parece redundante funciona para que no lo traten borrar desde el url)
    //     if ($user_id) {
    //         UserDB::delete_user($user_id);
    //         $_SESSION['success'] = "Usuario '$user_id' fue borrado exitosamente.";
    //     }

    //     header("Location: index.php?action=manage_users");
    //     exit;


    //====================================================================== \\
    //                          CREATE_product                           \\
    //====================================================================== \\

    case 'create_product':
        if (empty($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $_POST['name'] ?? '';
            $category = $_POST['category'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $min_stock = $_POST['min_stock'] ?? NULL;
            $price = $_POST['price'] ?? NULL;
            $created_at = date('Y-m-d H:i:s');

            // =========================
            // SUBIR IMAGEN
            // =========================
            $image_path = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

                $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
                $file_type = mime_content_type($_FILES['image']['tmp_name']);

                if (!in_array($file_type, $allowed_types)) {
                    $errores[] = "Solo se permiten imágenes JPG, PNG o WEBP.";
                } else {

                    $upload_dir = APP_ROOT . '/../public/images/products/';

                    // Crear carpeta si no existe
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $file_name = uniqid('prod_', true) . '.' . $extension;
                    $destination = $upload_dir . $file_name;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                        $image_path = 'images/products/' . $file_name;
                    } else {
                        $errores[] = "No se pudo subir la imagen.";
                    }
                }
            }

            // =========================
            // VALIDACIONES
            // =========================
            if (empty($name)) {
                $errores[] = "El nombre es obligatorio.";
            }

            if (empty($category)) {
                $errores[] = "La categoria es obligatoria.";
            }

            if (empty($quantity) || $quantity < 0) {
                $errores[] = "La cantidad es obligatoria y no puede ser menor a 0.";
            }

            if (empty($min_stock) || $min_stock < 0) {
                $errores[] = "La cantidad mínima es obligatoria.";
            }

            if (empty($price) || $price < 0) {
                $errores[] = "El precio es obligatorio.";
            }

            // =========================
            // CREAR PRODUCTO
            // =========================
            if (empty($errores)) {

                $prod_created = new Product(
                    null,
                    $name,
                    $category,
                    $quantity,
                    $min_stock,
                    $price,
                    $image_path,   // NUEVO
                    $created_at
                );

                ProductDB::create_product($prod_created);

                $_SESSION['success'] = "Producto '$name' creado exitosamente.";

                header("Location: index.php?action=product_list");
                exit;
            }
        }

        include APP_ROOT . '/views/products/product_form.php';
        break;

    //====================================================================== \\
    //                          EDIT_product                             \\
    //====================================================================== \\
    case 'edit_product':
        if (empty($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        $errores = [];
        $prod_id = $_GET['prod_id'] ?? NULL;
        $product = ProductDB::findProductById($prod_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $category = $_POST['category'] ?? '';
            $min_stock = $_POST['min_stock'] ?? NULL;
            $price = $_POST['price'] ?? NULL;

            $image_path = $product->getImagePath();

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
                $file_type = mime_content_type($_FILES['image']['tmp_name']);

                if (!in_array($file_type, $allowed_types)) {
                    $errores[] = "Solo se permiten imágenes JPG, PNG o WEBP.";
                } else {
                    $upload_dir = APP_ROOT . '/../public/images/products/';

                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }

                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $file_name = uniqid('prod_', true) . '.' . $extension;
                    $destination = $upload_dir . $file_name;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                        $image_path = 'images/products/' . $file_name;
                    } else {
                        $errores[] = "No se pudo subir la nueva imagen.";
                    }
                }
            }
            if (empty($name)) {
                $errores[] = "El nombre es obligatorio.";
            }
            if (empty($category)) {
                $errores[] .= "La categoria es obligatoria.";
            }
            if (empty($min_stock) || $min_stock < 0) {
                $errores[] .= "La cantidad minima es obligatoria y no puede ser menor o igual a 0.";
            }

            if (empty($price) || $price < 0) {
                $errores[] .= "El precio es obligatorio y no puede ser menor o igual a 0";
            }

            if (empty($errores)) {
                $product->setName($name);
                $product->setCategory($category);
                $product->setMinStock($min_stock);
                $product->setPrice($price);
                $product->setImagePath($image_path); // NUEVO
                ProductDB::edit_product($product);
                $_SESSION['success'] = "Producto '$name' editado exitosamente.";
                header("Location: index.php?action=product_list");
                exit;
            }
        }
        include APP_ROOT . '/views/products/edit_product_form.php';
        break;

    //====================================================================== \\
    //                          DASHBOARD                                    \\
    //====================================================================== \\
    case 'dashboard':
        if (empty($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        include APP_ROOT . '/views/dashboard.php';
        break;

    //====================================================================== \\
    //                          PRODUCT_LIST                                 \\
    //====================================================================== \\

    case 'product_list':
        if (empty($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        // Obteniendo el termino de busqueda desde el query string si existe
        // de lo contrario usa un string vacio
        // trim() elimina espacios innecesarios al inicio y al final
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $category = isset($_GET['category']) ? trim($_GET['category']) : '';
        // Determinando si el checkbox "mostrar solo vencidas" fue seleccionado
        // Esto es TRUE solamente cuando el parametro 'expired' existe y su valor es exactamente '1'
        $showExpired = isset($_GET['expired']) && $_GET['expired'] === '1';

        // Si no hay filtros activos (no hay texto de busqueda y no se selecciona "mostrar solo vencidas")
        // se cargan todas las oportunidades sin filtros
        $sort = $_GET['sort'] ?? 'asc';
        $products = ProductDB::getAndFilterProducts($search, $category);
        include APP_ROOT . '/views/products/product_list.php';
        break;

    //====================================================================== \\
    //                          REMOVE_STOCK                                 \\
    //====================================================================== \\
    case 'remove_stock':
        if (empty($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        $errores = [];
        $prod_id = $_GET['prod_id'] ?? NULL;
        $product = ProductDB::findProductById($prod_id);
        $product_name = $product->getName();
        $product_min = $product->getMinStock();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity_change = $_POST['quantity_change'];
            $timestamp = date('Y-m-d H:i:s');

            $inventory = new Inventory(null, $product->getProdId(), $quantity_change, "usage", $timestamp);

            if ($quantity_change > $product->getQuantity() || $quantity_change < 0) {
                $errores[] = "No puedes quitar mas cantidad de la que actualmente tienes y la cantidad a remover debe ser mayor a 0";
            }

            if (empty($errores)) {
                InventoryDB::removeStock($product, $quantity_change);
                InventoryDB::registerMovement($inventory);
                $quantity = ProductDB::getQuantity($prod_id); // solo para el if para poder comparar el valor rapido luego de quitarle stock
                                    $_SESSION['success'] = "Se ajusto la cantidad de '$product_name' correctamente (USAGE)";

                if ($quantity < $product->getMinStock()) {
                    $mail = new PHPMailer(true);
                    try {
                        // Server settings
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'oportunihub@gmail.com';
                        $mail->Password   = 'lrjcepxfzojykdwx';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;

                        // Recipients
                        $mail->setFrom('oportunihub@gmail.com', 'OportuniHub');
                        $mail->addAddress('carlosforteza242@gmail.com');


                        // Content y tuve que poner el css en cada misma linea pq gmail y lo demas me los ignora si hago una clase desde .css 
                        $mail->isHTML(true);
                        $mail->CharSet = 'UTF-8';
                        $mail->Subject = "Alerta: Stock bajo de $product_name";
                        $mail->Body = "
                            <html>
                            <head>
                                <meta charset='UTF-8'>
                            </head>
                            <body>
                                <h1>Atención: Stock bajo</h1>
                                <p>El siguiente producto ha alcanzado un nivel de stock crítico y se recomienda reabastecerlo a la mayor brevedad posible:</p>
                                <h2 style='font-weight: normal;'><strong>Producto:</strong> $product_name</h2>
                                <h4 style='font-weight: normal;'><strong>Cantidad actual:</strong> $quantity</h4>
                                <h4 style='font-weight: normal;'><strong>Cantidad mínima:</strong> $product_min</h4>
                                <p>Por favor, planifique el restock para evitar faltantes.</p>
                            </body>
                            </html>
                            ";

                        $mail->send();
                    } catch (Exception $e) {
                        error_log("No se pudo enviar el email. Mailer Error: {$mail->ErrorInfo}");
                    }
                }
                header("Location: index.php?action=product_list");
                exit;
            }
        }
        include APP_ROOT . '/views/products/remove_stock_form.php';
        break;



    //====================================================================== \\
    //                          ADD_STOCK                                    \\
    //====================================================================== \\
    case 'add_stock':
        if (empty($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        $errores = [];
        $prod_id = $_GET['prod_id'] ?? NULL;
        $product = ProductDB::findProductById($prod_id);
        $product_name = $product->getName();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity_change = $_POST['quantity_change'];
            $timestamp = date('Y-m-d H:i:s');

            $inventory = new Inventory(null, $product->getProdId(), $quantity_change, "restock", $timestamp);

            if ($quantity_change < 0) {
                $errores[] = "No numeros negativos ni 0";
            }

            if (empty($errores)) {
                InventoryDB::addStock($product, $quantity_change);
                InventoryDB::registerMovement($inventory);
                $_SESSION['success'] = "Se ajusto la cantidad de '$product_name' correctamente (RESTOCK)";
                header("Location: index.php?action=product_list");
                exit;
            }
        }
        include APP_ROOT . '/views/products/add_stock_form.php';
        break;



    //====================================================================== \\
    //                          DELETE_FILE_FROM_product                 \\
    //====================================================================== \\
    // case 'delete_file_from_product':
    //     $prod_id = $_GET['prod_id'];
    //     $opp = ProductDB::findproductById($prod_id);
    //     if ($_SESSION['user']['id'] === $opp->getPostedBy() || $_SESSION['user']['role'] === 'admin') {
    //         ProductDB::delete_file_from_product($prod_id, $opp->getAttachmentPath());
    //         if ($opp->getAttachmentPath()) {
    //             unlink($opp->getAttachmentPath()); // para borrar el attachment de la db
    //         }
    //         header("Location: index.php?action=edit_product&prod_id=$prod_id");
    //         exit;
    //     }
    //     include APP_ROOT . '/views/products/product_list.php';
    //     break;


    //====================================================================== \\
    //                          SUBSCRIPTION_LIST                            \\
    //====================================================================== \\
    // (traer los emails desde el modelo)
    // case 'subscriptions_list':
    //     $emails = Subscription::allEmails();
    //     include APP_ROOT . '/views/subscriptions/manage.php';
    //     break;


    //====================================================================== \\
    //                          SUBSCRIBE_EMAIL                              \\
    //====================================================================== \\
    // case 'subscribe_email':
    //     $emails  = [];
    //     $errores = [];
    //     $message = null;

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $email = trim($_POST['email'] ?? '');

    //         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //             $errores[] = 'Correo inválido.';
    //         } else if(!Subscription::subscribe($email)) {
    //             $errores[] = 'El correo ya está registrado.';
    //         } else {
    //             $_SESSION['success'] = "Correo '$email' suscrito exitosamente.";
    //             header("Location: index.php?action=subscriptions_list");
    //             exit;
    //         } 
    //     }

    //     // Siempre cargar todos los emails, aunque haya errores
    //     $emails = Subscription::allEmails();

    //     include APP_ROOT . '/views/subscriptions/manage.php';
    //     break;


    //====================================================================== \\
    //                          UNSUBSCRIBE_EMAIL                            \\
    //====================================================================== \\
    // case 'unsubscribe_email':
    //     $emails = Subscription::allEmails(); // para mostrar lista si es admin
    //     $errores = [];

    //     // Obtener email desde POST o GET
    //     $email = trim($_POST['email'] ?? $_GET['email'] ?? '');

    //     if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         Subscription::unsubscribe($email);
    //         $_SESSION['success'] = "Correo '$email' dado de baja exitosamente.";

    //         // Si viene por GET (desde link en email), podemos mostrar un mensaje simple
    //         if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //             include APP_ROOT . '/views/subscriptions/unsub_success.php';
    //             exit;
    //         } else {
    //             // Si es POST (desde admin) redirige a la lista
    //             header("Location: index.php?action=subscriptions_list");
    //             exit;
    //         }
    //     } elseif ($email) {
    //         $errores[] = 'E-mail inválido.';
    //     }

    //     include APP_ROOT . '/views/subscriptions/manage.php';
    //     break;


    //====================================================================== \\
    //                          DELETE_product                           \\
    //====================================================================== \\
    case 'delete_product':
        if (empty($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }
        $prod_id = $_GET['prod_id'] ?? NULL;
        $prod = ProductDB::findProductById($prod_id); // para validar en el backend los permisos, sin esto no se puede usar $opp->getPostedBy()
        $prod_name = $prod->getName();

        InventoryDB::delete_movement_from_product($prod); // pq no puedo borrar un valor de la tabla products cuando tiene un foreign key la tabla de movements

        ProductDB::delete_product($prod_id);

        $_SESSION['success'] = "Producto '$prod_name' eliminado exitosamente.";
        header("Location: index.php?action=product_list");
        exit;
        break;




    //====================================================================== \\
    //                          PROFILE                                      \\
    //====================================================================== \\
    // Perfil se muestra a cualquier ususario logeado
    // case 'profile':
    //     if (empty($_SESSION['user'])) {
    //         header("Location: index.php?action=product_list");
    //         exit;
    //     }

    //     $user_id = $_SESSION['user']['id'];
    //     $user = UserDB::findByUserId($user_id);

    //     include APP_ROOT . "/views/users/profile.php";
    //     break;

    //====================================================================== \\
    //                      INVENTORY_MOVEMENTS                              \\
    //====================================================================== \\
    case 'inventory_movements':
        if (empty($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $product_id = $_GET['product_id'] ?? '';
        $category = $_GET['category'] ?? '';
        $movement_date = $_GET['movement_date'] ?? '';

        $movements = InventoryDB::getAllMovements($product_id, $category, $movement_date);
        $products = ProductDB::getAndFilterProducts('');

        include APP_ROOT . '/views/inventory/movements.php';
        break;

    //====================================================================== \\
    //                          UPDATE_PROFILE                               \\
    //====================================================================== \\
    // case 'update_profile':
    //     if (empty($_SESSION['user'])) {
    //         header("Location: index.php?action=product_list");
    //         exit;
    //     }

    //     $user_id = $_SESSION['user']['id'];
    //     $email = trim($_POST['email']);
    //     $password = trim($_POST['password']);

    //     $user = UserDB::findByUserId($user_id);

    //     // validar email repetido
    //     $emailExistente = UserDB::findByEmail($email);

    //     if ($emailExistente && $emailExistente->getUserId() !== $user_id) {
    //         $errores[] = "El correo ya está en uso.";
    //     }

    //     $user->setEmail($email);

    //     // si password no fue cambiado, se queda igual
    //     if (!empty($password)) {
    //         if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*(\d|[^A-Za-z0-9])).{8,}$/', $password)) { // al menos una minuscula, al menos una mayuscula, almenos un numero o simbolo y minimo 8 caracteres
    //             $errores[] = "El password debe tener almenos 8 caracteres e incluir mayusculas, minusculas y un numero o simbolo.";
    //         } else {
    //             $password_hash = password_hash($password, PASSWORD_DEFAULT);
    //             $user->setPasswordHash($password_hash);
    //         }
    //     } else {
    //         $password_hash = null;
    //     }

    //     if ($errores) {
    //         include APP_ROOT . '/views/users/profile.php';
    //         break;
    //     }

    //     UserDB::update_profile($user);

    //     // Actualizar sesion
    //     $_SESSION['user']['email'] = $email;

    //     // Mensaje de exito
    //     $_SESSION['success'] = "Perfil '$user_id' actualizado exitosamente.";

    //     header("Location: index.php?action=profile");
    //     exit;
    //     break;



    //====================================================================== \\
    //                          DEFAULT                                      \\
    //====================================================================== \\
    default:
        // Cargando la vista correspondiente
        if (empty($_SESSION['user'])) {
            include APP_ROOT . '/views/auth/login.php';
        } else {
            include APP_ROOT . '/views/dashboard.php';
            break;
        }
        break;
}
