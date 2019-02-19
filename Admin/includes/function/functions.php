<?php
/*Title function that echo the page title
 *in case the page has the variable $pageTitle
 * and echo default title for other page
*/
function getTitle(){
    global $pageTitle;
    if (isset($pageTitle)){
        echo  $pageTitle;
    }else {
        echo 'Default';
    }
}
/*
 * Redirect Function [This Function Accept Parameter]
 * $theMsg =Echo the  message [Error | Success | Waring]
 * $seconds= seconds before redirecting
 * $url = the link you want to redirect to
 */
function redirectHome($theMsg,$url=null ,$seconds=3){
    if($url === null){
        $url= 'index.php';
    }else{
        if(isset($_SERVER['HTTP_REFERER'])&& $_SERVER['HTTP_REFERER']!==''){
            $url=$_SERVER['HTTP_REFERER'];
            $link = "Previous Page";
        }else{
            $url='index.php';
            $link = 'Home page';
        }
    }
    echo $theMsg;
    echo "<div class='alert alert-info'>You will be directed To After $seconds Sec.</div>";
    header("refresh:$seconds;url=$url");
    exit();
}
/*
 * function Check  Item  in data base [Function Accept Parameter]
 * $select = the item to select       [ex : user | item | Category]
 * $from   = The table to select From [ex: users | item | categories]
 * $value  = The value of Select
 * */
function checkItem($select , $from , $value){
    global  $con ;
    $statment=$con->prepare("SELECT $select FROM $from WHERE $select=?");
    $statment->execute(array($value));
    $count=$statment->rowCount();
    return $count;
}

/*
 * Count number of items function
 * Function  Count no.of Items  rows
 * $item  = The item to Choose From
 * $table = The table to Choose From
 * */
function countItems($item , $table ){
    global $con ;
    $stmt2=$con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}
/*
 * Get latest records function
 * function to get latest  items from database [users ,Items , comments ]
 * $select = Field To Select
 * $table  = The table to choose form
 * $limit  = Number of records to get
 * $order  = To order the item [ ASC , DSC ]
 */
function getLatest($select , $table , $order , $limit=5){
    global  $con;
    $getStmt= $con->prepare("SELECT $select FROM $table ORDER  BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows=$getStmt->fetchAll();
    return $rows;
}
