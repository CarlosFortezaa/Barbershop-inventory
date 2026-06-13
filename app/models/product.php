<?php

class Product {
    private $id, $name, $category, $quantity, $min_stock, $price, $image_path, $created_at;

    public function __construct($id, $name, $category, $quantity, $min_stock, $price, $image_path, $created_at){
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->quantity = $quantity;
        $this->min_stock = $min_stock;
        $this->price = $price;
        $this->image_path = $image_path;
        $this->created_at = $created_at;
    }

    public function getProdId() {
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getCategory(){
        return $this->category;
    }

    public function getQuantity(){
        return $this->quantity;
    }

    public function getMinStock(){
        return $this->min_stock;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getImagePath(){
        return $this->image_path;
    }

    public function getCreatedAt(){
        return $this->created_at;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setMinStock($min_stock) {
        $this->min_stock = $min_stock;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setImagePath($image_path) {
        $this->image_path = $image_path;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }
}