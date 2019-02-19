<?php
/*==============================================
 == Manage Member page
 == you can Add | Edit | Delete Member From Here
 ===============================================
 */
session_start();
$pageTitle ='Members';
if(isset($_SESSION['Username'])){
    include 'init.inc';
    $do=isset($_GET['do'])?$_GET['do']:'manage';
    if($do=='manage'){ // Manage page
        $query='';
        if(isset($_GET['page'])&& $_GET['page']== 'pending'){
            $query='AND RegStatus=0';
        }
        $stmt=$con->prepare("SELECT * FROM users WHERE GroupID !=1 $query");
        $stmt->execute();
        $rows=$stmt->fetchAll();
        //start echo for write HTMl at PHP code
       echo '
             <h1 class="text-center">Add Member</h1>
             <div class="container">
               <div class="table-responsive text-center">
                  <table class="main-table table table-bordered">
                    <tr>
                       <td>ID</td>
                       <td>Username</td>
                       <td>Email</td>
                       <td>Fullname</td>
                       <td>Regiterd Date</td>
                       <td>Control</td>
                    </tr>
       ';
       foreach ($rows as $row){
           echo"<tr>";
               echo "<td>".$row['UserID'].  "</td>";
               echo "<td>".$row['Username']."</td>";
               echo "<td>".$row['Email'].   "</td>";
               echo "<td>".$row['FullName']."</td>";
               echo "<td>".$row['Date'].    "</td>";
               echo "<td>
                        <a href='member.php?do=edit&userid=".$row['UserID']." 'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                        <a href='member.php?do=delete&userid=".$row['UserID']." 'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                        if ($row['RegStatus']== 0){
                            echo "<a href='member.php?do=activate&userid=".$row['UserID']. "'class='btn btn-info activate'>Activate</a>";
                        }
               echo "</td>";
           echo"</tr>";
       }
       echo'
                    
                  </table>
               </div>
                <a href="member.php?do=add" class="btn btn-primary"> <i class="fa fa-plus"></i> Add new member</a>
             </div>
       ';
        //End echo for write HTMl at PHP code
    }elseif ($do=='add'){// add page
        echo '<h1 class="text-center">Add Member</h1>';
        //start echo for write HTMl at PHP code
        echo "<div class='container'>
                <form class='form-horizontal' action='member.php?do=insert' method='post'>
                   <!--Start user name field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>User name</label>
                      <div class='col-sm-10'>
                        <input type='text' name='username' class='form-control'  autocomplete='off' required='required'/>
                      </div>
                    </div>
                    <!--End user name field-->
                    <!--Start Password field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Password</label>
                      <div class='col-sm-10'>
                        <input type='password' name='password' class='password form-control' autocomplete='new-password' required='required'/>
                        <i class='show-pass fa fa-eye fa-2x'></i>
                      </div>
                    </div>
                    <!--End Password field-->
                    <!--Start Full name field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Full name</label>
                      <div class='col-sm-10'>
                        <input type='text' name='fullname' class='form-control' required='required'/>
                      </div>
                    </div>
                    <!--End Full name field-->
                    <!--Start Email field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Email</label>
                      <div class='col-sm-10'>
                        <input type='text' name='email' class='form-control' autocomplete='off' required='required'/>
                      </div>
                    </div>
                    <!--End Email field-->
                    <!--Start Submit Button-->
                    <div class='form-group'>
                      <div class='col-sm-offset-2 col-sm-10'>
                        <input type='submit' value='Add member' class='btn btn-success btn-block'/>
                      </div>
                    </div>
                    <!--End Submit Button-->
                </form>
             </div>
        ";//End echo for write HTMl at PHP code
    }elseif ($do=='insert'){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $user=$_POST['username'];
            $pass=sha1($_POST['password']);
            $name=$_POST['fullname'];
            $email=$_POST['email'];
            $hashPass=sha1($_POST['password']);
            $formErrors=array();
            if (strlen($user) < 4){
                $formErrors[]='user name must be more than 4 character';
            }
            if (strlen($user) > 20){
                $formErrors[]='user name must be less than 20 character';
            }
            if (empty($user)){
                $formErrors[]='user name must not be empty';
            }
            if (empty($pass)){
                $formErrors[]='pass must not be empty';
            }
            if (empty($email)){
                $formErrors[]='email must not be empty';
            }
            if (empty($name)){
                $formErrors[]='Full name must not be empty';
            }
            foreach ($formErrors as $error){
                echo "<div class='alert alert-danger'>" .$error."</div>";
            }
            if(empty($formErrors)){
                // check if userinfo in database
                   $check=checkItem("Username" ,"users" , $user);
                   if($check == 1 ){
                      $theMsg = "<div class='alert alert-danger'>this user is exist</div>";
                      redirectHome($theMsg , 'back');
                   }else{
                       $stmt=$con->prepare('INSERT INTO users (Username ,Password , Email ,FullName,RegStatus ,Date) VALUES ( ? , ? , ? , ?, 1 ,now())');
                       $stmt->execute(array($user , $hashPass , $email , $name));
                       $count=$stmt->rowCount();
                       $theMsg = '<div class="alert alert-success">'.$count .'Insert Record</div>';
                       redirectHome($theMsg , 'back');
                   }
            }
        }else{
            $theMsg='<div class="alert alert-danger ">you cant browse page directly</div>';
            redirectHome($theMsg , 'back');
        }
    }elseif ($do=='edit'){//Edit page
        $userid=isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
        $stmt=$con->prepare('SELECT * FROM users WHERE UserID=?');
        $stmt->execute(array($userid));
        $row=$stmt->fetch();
        $count=$stmt->rowCount();
        //start if condtion count
        if ($count >0){
            // this condtion to count if userid in database show his data
            echo "<h1 class='text-center'>Edit Member</h1>";
            //start echo for write HTMl at PHP code
            echo "<div class='container'>
                <form class='form-horizontal' action='?do=update' method='post'>
                   <input type='hidden' name='userid' value='$userid'>
                   <!--Start user name field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>User name</label>
                      <div class='col-sm-10'>
                        <input type='text' name='username' class='form-control'  value='$row[Username]' autocomplete='off' required='required'/>
                      </div>
                    </div>
                    <!--End user name field-->
                    <!--Start Password field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Password</label>
                      <div class='col-sm-10'>
                        <input type='hidden' name='oldpassword' value='$row[Password]'/>
                        <input type='password' name='newpassword' class='form-control' autocomplete='new-password' placeholder='Leave Blank if you dont want to change '/>
                      </div>
                    </div>
                    <!--End Password field-->
                    <!--Start Full name field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Full name</label>
                      <div class='col-sm-10'>
                        <input type='text' name='fullname' class='form-control' value='$row[FullName]' required='required'/>
                      </div>
                    </div>
                    <!--End Full name field-->
                    <!--Start Email field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Email</label>
                      <div class='col-sm-10'>
                        <input type='text' name='email' class='form-control' value='$row[Email]' required='required' autocomplete='off'/>
                      </div>
                    </div>
                    <!--End Email field-->
                    <!--Start Submit Button-->
                    <div class='form-group'>
                      <div class='col-sm-offset-2 col-sm-10'>
                        <input type='submit' value='Save' class='btn btn-primary btn-block'/>
                      </div>
                    </div>
                    <!--End Submit Button-->
                </form>
             </div>
            ";//End echo for write HTMl at PHP code
        }else{
            echo  "<div class='container'>";
                   $theMsg="<div class='alert alert-danger'>There NO such ID</div>";
                   redirectHome($theMsg);
            echo  "</div>";
        }
        //End if condtion count
    }elseif ($do=='update'){
        echo '<h1 class="text-center">Update Member</h1>';
        echo  '<div class="container">';
            if ($_SERVER['REQUEST_METHOD']=='POST'){
                   $id   =$_POST['userid'];
                   $user =$_POST['username'];
                   $email=$_POST['email'];
                   $name =$_POST['fullname'];
                   //Password Trick
                    $pass=empty($_POST['newpassword'])?$_POST['oldpassword']:sha1($_POST['newpassword']);
                    //Validate the form by using PHP
                    $formErrors=array();
                    if (strlen($user) < 4 ){
                        $formErrors[]='<div class="alert alert-danger">User name cant less 4 letter</div>';
                    }
                    if (strlen($user) > 20 ){
                        $formErrors[]='<div class="alert alert-danger">User name cant more 20 letter</div>';
                    }
                    if (empty($user)){
                        $formErrors[]='<div class="alert alert-danger">User name cant be empty</div>';
                    }
                    if (empty($name)){
                        $formErrors[]='<div class="alert alert-danger">Full name cant be empty</div>';
                    }
                    if (empty($email)){
                        $formErrors[]='<div class="alert alert-danger">Email cant be empty</div>';
                    }
                    foreach ($formErrors as $error){
                        echo  $error;
                    }
                  //Check If there's NO error Proceed the update opertaion
                  if (empty($formErrors)) {
                      //Update The database with this info
                      $stmt = $con->prepare('UPDATE users SET Username=? ,Email=? , FullName=? ,Password=? WHERE UserID=?');
                      $stmt->execute(array($user, $email, $name, $pass, $id));
                      //Sucsses
                      $theMsg='<div class="alert alert-success">' . $stmt->rowCount() . 'Record Updated</div>';
                      redirectHome($theMsg , 'back');
                  }
            }else{
                $theMsg='<div class="alert alert-danger">Sorry Don\'t Browse this page directly </div>';
                redirectHome($theMsg);
            }
        echo '</div>';

    }elseif($do==='delete'){//Delete Member page
              $userid=isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
              $check=checkItem('userid' , 'users' , $userid);
              if ($check > 0){
                  $stmt=$con->prepare('DELETE FROM users WHERE UserID=:zuser LIMIT=1');
                  $stmt->bindParam(":zuser",$userid);
                  $stmt->execute();
                  $theMsg="<div class='alert alert-success'>".$stmt->rowCount()."Record Deleted</div>";
                  redirectHome($theMsg);
              }else{
                  $theMsg="<div class='alert alert-warning'>This ID is Not Exist</div>";
                  redirectHome($theMsg);
              }
    }elseif ($do == 'activate'){ //Activation Page
        $userid=isset($_GET['userid'])&& is_numeric($_GET['userid'])?intval($_GET['userid']):0;
        $check=checkItem('userid' , 'users' , $userid);
        if ($check > 0){
            $stmt=$con->prepare("UPDATE users SET RegStatus=1 WHERE  UserID=?");
            $stmt->execute(array($userid));
            $theMsg="<div class='alert alert-success'>".$stmt->rowCount()."Record Activated</div>";
            redirectHome($theMsg);
        }else{
            $theMsg="<div class='alert alert-warning'>This ID is Not Exist</div>";
            redirectHome($theMsg);
        }
    }
    include 'includes/templates/footer.inc';
}else{
    header('location: index.php');
    exit();
}