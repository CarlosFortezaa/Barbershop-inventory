<?php

class InventoryMovementDB {

private $db;

public function __construct($database){

$this->db = $database;

}

public function getAll(){

$query = "
SELECT im.*, p.name AS product_name
FROM inventory_movement im
JOIN products p ON im.product_id = p.id
ORDER BY timestamp DESC
";

return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);

}

public function create($product_id,$quantity,$type){

$query = "
INSERT INTO inventory_movement
(product_id, quantity_change, movement_type)
VALUES (?,?,?)
";

$stmt = $this->db->prepare($query);

$stmt->execute([$product_id,$quantity,$type]);

}

}