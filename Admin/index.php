<?php
    session_start();
    $noNavbar='';
    $pageTitle='login';
if (isset($_SESSION['Username'])){
        header('location:dashboard.php');//redirect to dashboard page
    }
    include "init.inc";
    //Check IF user coming from HTTP Post Requset
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        $username=$_POST['user'];
        $password=$_POST['pass'];
        $hashedPass=sha1($password);
        //Check IF user exist at database
        $stmt=$con ->prepare('SELECT UserID , Username ,Password FROM users WHERE Username=? AND Password=? AND  GroupID=1 LIMIT 1');
        $stmt->execute(array($username,$hashedPass));
        $row= $stmt->fetch();
        $count=$stmt->rowCount();
        //if count > 0 this mean the database contain information about this record
        if ($count > 0){
            $_SESSION['Username']=$username; // Register ssesion name
            $_SESSION['ID']=$row['UserID'];  // Register session ID
            header('location:dashboard.php');//redirect to dashboard page
            exit();
        }
    }

?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <h4>Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off"/>
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password"/>
    <input class="btn btn-primary btn-block" type="submit" value="login" />
</form>
<?php include "includes/templates/footer.inc";?>