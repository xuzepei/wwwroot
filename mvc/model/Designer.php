<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Designer {

    public $id;
    public $name;
    public $age;
    public $gender;
    public $head_image_url;
    public $desc;
    public $phone;
    public $type;

    public function __construct($designer_info)
    {
        $this->id = $designer_info['id'];
        $this->name = $designer_info['name'];
        $this->age = $designer_info['age'];
        $this->gender = $designer_info['gender'];
        $this->head_image_url = $designer_info['head_image_url'];
        $this->desc = $designer_info['description'];
        $this->phone = $designer_info['phone'];
        $this->type = $designer_info['type'];
    }

}

?>
