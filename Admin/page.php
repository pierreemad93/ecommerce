<?php
$do='';
if (isset($_GET['do'])){
    $do=$_GET['do'];
}else{
    $do='manage';
}

//if the page is main page
if ($do== 'manage'){
    echo 'Welcome you are in manage category page';
}elseif ($do=='add'){
    echo 'Welcome you are in add category page';
}else{
    echo 'Error';
}
