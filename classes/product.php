<?php
    class Product{
        public $pid;
        public $pname;
        public $category;
        public $pinfo;
        public $price;
        public $image;
        public $userid;
        public $qty;

        function __construct($pid,$pname,$category,$pinfo,$price,$image,$userid,$qty){
            $this->pid=$pid;
            $this->pname=$pname;
            $this->category=$category;
            $this->pinfo=$pinfo;
            $this->price=$price;
            $this->image=$image;
            $this->userid=$userid;
            $this->qty=$qty;
        }
    }
?>