<?php
include "connect.php";
include 'includes/function/functions.php';
include "includes/templates/header.inc";
//Include navbar on all pages expect the one with $noNavbar
if(!isset($noNavbar)){
    include "includes/templates/navbar.inc";

}
