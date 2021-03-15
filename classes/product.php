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

        function __construct($userid,$email,$fname,$lname,$address,$state,$city,$phno,$gender,$dob,$category){
            $this->pid=$pid;
            $this->pname=$pname;
            $this->category=$category;
            $this->pinfo=$pinfo;
            $this->image=$image;
            $this->userid=$userid;
            $this->qty=$qty;
            $this->phno=$phno;
            $this->gender=$gender;
            $this->dob=$dob;
            $this->category=$category;
        }
    }
?>