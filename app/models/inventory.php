<?php
class Inventory {
    private $id, $product_id, $quantity_change, $movement_type, $timestamp;

    public function __construct($id, $product_id, $quantity_change, $movement_type, $timestamp) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->quantity_change = $quantity_change;
        $this->movement_type = $movement_type;
        $this->timestamp = $timestamp;

    }

    // Getters
    public function getMovementId(){ 
        return $this->id;
    }

    public function getProdId(){ // producto que pertenece al movement hecho 
        return $this->product_id;
    }

    public function getQuantityChange(){
        return $this->quantity_change;
    }

    public function getMovementType(){
        return $this->movement_type;
    }

    public function getTimestamp(){
        return $this->timestamp;
    }


    // Setters
    public function setMovementId($id){
        $this->id = $id;
    }

    public function setProdId($product_id){
        $this->product_id = $product_id;
    }

    public function setQuantityChange($quantity_change){
        $this->quantity_change = $quantity_change;
    }

    public function setMovementType($movement_type){
        $this->movement_type = $movement_type;
    }

    public function setTimestamp($timestamp){
        $this->timestamp = $timestamp;
    }
}
