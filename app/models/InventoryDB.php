<?php

class InventoryDB
{

    public static function registerMovement(Inventory $inv)
    {

        $db = Database::getDB();

        $query = "INSERT INTO inventory_movement (product_id, quantity_change, movement_type, timestamp)
            VALUES (:product_id, :quantity_change, :movement_type, :timestamp)";

        $statement = $db->prepare($query);

        $statement->bindValue(':product_id', $inv->getProdId());
        $statement->bindValue(':quantity_change', $inv->getQuantityChange());
        $statement->bindValue(':movement_type', $inv->getMovementType());
        $statement->bindValue(':timestamp', $inv->getTimestamp());

        $statement->execute();

        $statement->closeCursor();
    }

    public static function removeStock(Product $prod, $cantidad)
    { // quantity actual,  quantity changed
        // Obtener conexion a base de datos
        $db = Database::getDB();

        $new_stock = $prod->getQuantity() - $cantidad;

        $query = "UPDATE products
                  SET quantity = :quantity
                  WHERE id = :id";

        $statement = $db->prepare($query);

        $statement->bindValue(':quantity', $new_stock);
        $statement->bindValue(':id', $prod->getProdId());

        $statement->execute();

        $statement->closeCursor();
    }

    public static function addStock(Product $prod, $cantidad)
    {
        // Obtener conexion a base de datos
        $db = Database::getDB();

        $new_stock = $prod->getQuantity() + $cantidad;

        $query = "UPDATE products
                  SET quantity = :quantity
                  WHERE id = :id";

        $statement = $db->prepare($query);

        $statement->bindValue(':quantity', $new_stock);
        $statement->bindValue(':id', $prod->getProdId());

        $statement->execute();

        $statement->closeCursor();
    }

    public static function delete_movement_from_product(Product $prod)
    {
        $db = Database::getDB();

        $query = "DELETE FROM inventory_movement WHERE product_id = :id";

        $statement = $db->prepare($query);

        $statement->bindValue(':id', $prod->getProdId());

        $statement->execute();

        $statement->closeCursor();
    }

    public static function getAllMovements($product_id = '', $category = '', $movement_date = '') {
    $db = Database::getDB();

    $query = "
        SELECT 
            inventory_movement.*, 
            products.name AS product_name,
            products.category AS product_category
        FROM inventory_movement
        INNER JOIN products
            ON inventory_movement.product_id = products.id
        WHERE 1 = 1
    ";

    $params = [];

    if (!empty($product_id)) {
        $query .= " AND inventory_movement.product_id = :product_id";
        $params[':product_id'] = $product_id;
    }

    if (!empty($category)) {
        $query .= " AND products.category = :category";
        $params[':category'] = $category;
    }

    if (!empty($movement_date)) {
        $query .= " AND DATE(inventory_movement.timestamp) = :movement_date";
        $params[':movement_date'] = $movement_date;
    }

    $query .= " ORDER BY inventory_movement.timestamp DESC";

    $statement = $db->prepare($query);

    foreach ($params as $key => $value) {
        $statement->bindValue($key, $value);
    }

    $statement->execute();
    $movements = $statement->fetchAll();
    $statement->closeCursor();

    return $movements;
}
    public static function get5Movements()
    {
        $db = Database::getDB();

        $query = "SELECT product_id, quantity_change, movement_type, timestamp, products.name AS product_name
                    FROM inventory_movement
                    INNER JOIN products
                    ON product_id = products.id
                    ORDER BY timestamp DESC
                    LIMIT 5";

        $statement = $db->prepare($query);
        $statement->execute();
        $movements = $statement->fetchAll();
        $statement->closeCursor();

        return $movements;
    }
    public static function getMostUsedProducts($limit = 5)
{
    $db = Database::getDB();

    $query = "SELECT products.name AS product_name,
                     SUM(inventory_movement.quantity_change) AS total_used
              FROM inventory_movement
              INNER JOIN products
                  ON inventory_movement.product_id = products.id
              WHERE inventory_movement.movement_type = 'usage'
              GROUP BY inventory_movement.product_id, products.name
              ORDER BY total_used DESC, products.name ASC
              LIMIT :limit";

    $statement = $db->prepare($query);
    $statement->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    return $rows;
}

public static function getLeastUsedProducts($limit = 5)
{
    $db = Database::getDB();

    $query = "SELECT products.name AS product_name,
                     SUM(inventory_movement.quantity_change) AS total_used
              FROM inventory_movement
              INNER JOIN products
                  ON inventory_movement.product_id = products.id
              WHERE inventory_movement.movement_type = 'usage'
              GROUP BY inventory_movement.product_id, products.name
              ORDER BY total_used ASC, products.name ASC
              LIMIT :limit";

    $statement = $db->prepare($query);
    $statement->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    return $rows;
}
}
