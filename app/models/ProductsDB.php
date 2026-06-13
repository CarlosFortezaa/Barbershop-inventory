<?php

class ProductDB {

    /**** Obtener y filtrar oportunidades ****/
    // Metodo estatico para obtener todas las oportunidades de la base de datos
    // aplica opcionalmente filtros al introducirse un texto de busqueda o activar el checkbox de "mostrar solo vencidas"
    public static function getAndFilterProducts($search = '', $category = '') {
    $db = Database::getDB();

    $query = "SELECT * FROM products WHERE 1 = 1";
    $params = [];

    if (!empty($search)) {
        $search = trim($search);
        $params[':search'] = "%$search%";
        $query .= " AND (name LIKE :search OR category LIKE :search OR price LIKE :search)";
    }

    if (!empty($category)) {
        $query .= " AND category = :category";
        $params[':category'] = $category;
    }

    $statement = $db->prepare($query);
    foreach ($params as $key => $value) {
        $statement->bindValue($key, $value);
    }

    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $products = [];
    foreach ($rows as $row) {
       $products[] = new Product(
       $row['id'],
       $row['name'],
       $row['category'],
       $row['quantity'],
       $row['min_stock'],
       $row['price'],
       $row['image_path'] ?? null,
       $row['created_at']
);
    }
    return $products;
}

    /**** Crear oportunidad ****/
    // Metodo estatico para insertar una nueva oportunidad en la base de datos
    public static function create_product(Product $prod){
        // Obteniendo la conexion a la base de datos
        $db = Database::getDB();

        // Query de insercion
        // en este query no se usa opp_id ya que esta como autoincrement en la tabla de la db
        $query = "INSERT INTO products (name, category, quantity, min_stock, price, image_path, created_at)
          VALUES (:name, :category, :quantity, :min_stock, :price, :image_path, :created_at)";
        $min_stock = (int) $prod->getMinStock();
        $price = (float) $prod->getPrice();
        // Preparando el query
        $statement = $db->prepare($query);
        // Vinculando cada parametro con su valor correspondiente
        $statement->bindValue(':name', $prod->getName());
        $statement->bindValue(':category', $prod->getCategory());
        $statement->bindValue(':quantity', $prod->getQuantity());
        $statement->bindValue(':min_stock', $min_stock);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':created_at', $prod->getCreatedAt());
        $statement->bindValue(':image_path', $prod->getImagePath());
        // Ejecutando el query
        $statement->execute();
        // Cerrando el cursor para liberar recursos
        $statement->closeCursor();
    }

    /**** Editar Oportunidad ****/
    // Metodo estatico para actualizar los datos de una oportunidad existente
    public static function edit_product(Product $prod){
        // Obteniendo la conexion a la base de datos
        $db = Database::getDB();

        // Query de actualizacion
        // Actualiza todos los campos excepto date_posted y posted_by que permanecen sin cambios
        $query = "UPDATE products
            SET name = :name,
                category = :category,
                min_stock = :min_stock,
                price = :price,
                image_path = :image_path
          WHERE id = :id";
        // Preparando el query
        $statement = $db->prepare($query);
        // Vinculando cada parametro con su valor correspondiente
        $statement->bindValue(':id', $prod->getProdId());
        $statement->bindValue(':name', $prod->getName());
        $statement->bindValue(':category', $prod->getCategory());
        $statement->bindValue(':min_stock', $prod->getMinStock());
        $statement->bindValue(':price', $prod->getPrice());
        $statement->bindValue(':image_path', $prod->getImagePath());
        // Ejecutando el query
        $statement->execute();
        // Cerrando el cursor para liberar recursos
        $statement->closeCursor();
    }

    /**** Borrar Oportunidad ****/
    // Metodo estatico para eliminar una oportunidad de la base de datos
    public static function delete_product($id){
        // Obteniendo la conexion a la base de datos
        $db = Database::getDB();

        // Query de eliminacion basado en el ID de la oportunidad
        $query = "DELETE FROM products
                WHERE id = :id";
        // Preparando el query
        $statement = $db->prepare($query);
        // Vinculando el parametro opp_id con su valor
        $statement->bindValue(':id', $id);
        // Ejecutando el query
        $statement->execute();
        // Cerrando el cursor para liberar recursos
        $statement->closeCursor();
    }


    /**** Obtener oportunidad por ID (util para mantener los campos con la info de la respetiva oportunidad al editarla) ****/
    // Metodo estatico que busca y devuelve una oportunidad especifica por su ID
    // Util para llenar formularios de edicion con los datos actuales
    public static function findProductById($id){
        // Obteniendo la conexion a la base de datos
        $db = Database::getDB();

        // Query para seleccionar una oportunidad especifica por su ID
        $query = "SELECT * FROM products WHERE id = :id";
        // Preparando el query
        $statement = $db->prepare($query);
        // Vinculando el parametro opp_id con su valor
        $statement->bindValue(':id', $id);
        // Ejecutando el query
        $statement->execute();
        // Obteniendo una sola fila como arreglo asociativo
        $row = $statement->fetch();
        // Cerrando el cursor para liberar recursos
        $statement->closeCursor();

        // Si se encontro una oportunidad con ese ID
        if($row) {
            // Creando y devolviendo un objeto Opportunity con los datos obtenidos
            return new Product(
             $row['id'],
             $row['name'],
             $row['category'],
             $row['quantity'],
             $row['min_stock'],
             $row['price'],
             $row['image_path'] ?? null,
             $row['created_at']
        );
        } else {
            // Si no se encuentra la oportunidad devolvemos null
            return null;
        }
    }

    public static function getQuantity($id){ // quantity de item en especifico para que en lo del envio de email la condicion tome la cantidad actualizada al momento, por ej sin esto si quito stock de 1 item hasta un valor menor que minstock pues no detectaba que quantity < min_stock pero si volvia a bajar el stock pues si lo detectaba
        $db = Database::getDB();

        $query = "SELECT quantity FROM products WHERE id = :id";

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $quantity = $row['quantity'];
        $statement->closeCursor();

        return $quantity;
    }

    public static function totalQuantity(){
        $db = Database::getDB();

        $query = "SELECT SUM(quantity) AS total_quantity FROM products";

        $statement = $db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();
        $total_quantity = $row['total_quantity'];
        $statement->closeCursor();

        return $total_quantity;
    }

    public static function maxQuantityProduct(){
        $db = Database::getDB();

        $query = "SELECT MAX(quantity) AS max_quantity FROM products";

        $statement = $db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();
        $max_quantity = $row['max_quantity'];
        $statement->closeCursor();

        return $max_quantity;
    }

    public static function zeroStockProduct(){
        $db = Database::getDB();

        $query = "SELECT COUNT(quantity) AS zero_stock FROM products WHERE quantity = 0";

        $statement = $db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();
        $zeroStock = $row['zero_stock'];
        $statement->closeCursor();

        return $zeroStock;
    }

    public static function lowQuantityProduct(){
        $db = Database::getDB();

        $query = "SELECT COUNT(quantity) AS low_quantity FROM products WHERE quantity < min_stock";

        $statement = $db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();
        $low_quantity = $row['low_quantity'];
        $statement->closeCursor();

        return $low_quantity;
    }

    public static function getLowQuantityProducts(){
        $db = Database::getDB();

        $query = "SELECT name, quantity, min_stock FROM products WHERE quantity < min_stock LIMIT 5";

        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        return $rows;
    }

    public static function totalInventoryValue(){
        $db = Database::getDB();

        $query = "SELECT SUM(price * quantity) AS total_inventory_value FROM products";

        $statement = $db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();
        $totalInventoryValue = $row['total_inventory_value'];
        $statement->closeCursor();

        return $totalInventoryValue;
    }

    public static function getProductsByCategory() {
    $db = Database::getDB();

    $query = "SELECT category, COUNT(*) AS total_products
              FROM products
              GROUP BY category
              ORDER BY total_products DESC, category ASC";

    $statement = $db->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    return $rows;
 }
}