<?php
//declaracion clase usario
class User {
    private $user_id, $password_hash;
    // Constructor 

    public function __construct($user_id, $password_hash) {
        $this->user_id = $user_id;
        $this->password_hash = $password_hash;
    }
    //metodo para obtener el ID del usuario
    public function getUserId() { 
        return $this->user_id; 
    }
    //metodo para obtener el hash de la contraseña
    public function getPasswordHash() { 
        return $this->password_hash; 
    }

    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function setPasswordHash($password_hash){
        $this->password_hash = $password_hash;
    }
}
