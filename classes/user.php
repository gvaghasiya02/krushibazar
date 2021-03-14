<?php
    class User{
        public $userid;
        public $email;
        public $fname;
        public $lname;
        public $address;
        public $state;
        public $city;
        public $phno;
        public $gender;
        public $dob;
        public $category;

        function __construct($userid,$email,$fname,$lname,$address,$state,$city,$phno,$gender,$dob,$category){
            $this->userid=$userid;
            $this->email=$email;
            $this->fname=$fname;
            $this->lname=$lname;
            $this->address=$address;
            $this->state=$state;
            $this->city=$city;
            $this->phno=$phno;
            $this->gender=$gender;
            $this->dob=$dob;
            $this->category=$category;
        }

        function getUserId(){
            return $this->userid;
        }

        function getUserEmail(){
            return $this->email;
        }
    }
?>