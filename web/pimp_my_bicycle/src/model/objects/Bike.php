<?php

class Bike {
    public $id;
    public $user_id;

    public $data;
    public $likes;

    public function __construct($id, $user_id, $data, $likes=0){
        $this->id = $id;
        
        $this->user_id = $user_id;
        $this->data = $data;
        $this->likes = $likes;
    }
}