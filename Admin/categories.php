<?php
/*==============================================
 == Manage Categories page
 == you can Add | Edit | Delete Member From Here
 ===============================================
 */
session_start();
$pageTitle='categories';
if (isset($_SESSION['Username'])){
    include 'init.inc';
    $do=isset($_GET['do'])?$_GET['do']:'manage' ;
    if($do== 'manage'){
        $sort='ASC';
        $sortArray=array('ASC', 'DESC');
        if(isset($_GET['sort']) && in_array($_GET['sort'],$sortArray)){
            $sort=$_GET['sort'];
        }
        $stmt2=$con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $stmt2->execute(array());
        $cats=$stmt2->fetchAll();
        //start echo for write HTMl at PHP code
        echo '
               <h1 class="text-center">Manage Categories</h1>
               <div class="container categories">
                 <div class="panel panel-default">
                   <div class="panel-heading">
                      Manage Categories
                      <div class="ordering pull-right">
                         Order by: 
                         <a  class="" href="?sort=ASC">ASC |</a>
                         <a  class="" href="?sort=DESC">DESC</a>
                      </div>
                   </div>
                   <div class="panel-body">';
                     foreach ($cats as $cat){
                         echo "<div class='cat'>";
                             echo "<div class='hidden-buttons'>";
                                  echo "<a href='#' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                                  echo "<a href='#' class='btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
                             echo "</div>";
                             echo  "<h3>". $cat['Name'] . "</h3>";
                             echo  "<p>" . $cat['Description'] . "</p>";
                             if($cat['Visibility'] == 1){echo "<span class='visibility'>visibility Hidden</span>";}
                             if($cat['Allow_Comment'] == 1){echo "<span class='commenting'>Comment Disabled</span>";}
                             if($cat['Allow_Ads'] == 1){echo "<span class='ads'>ADS Disabled</span>";}
                         echo "</div>";
                         echo "<hr>";
                     }
                   '</div>
                 </div>
               </div>
        ';
        //End echo for write HTMl at PHP code
    }elseif ($do=='add'){//add Category page
        echo '<h1 class="text-center">Add New Category</h1>';
        //start echo for write HTMl at PHP code
        echo "<div class='container'>
                <form class='form-horizontal' action='categories.php?do=insert' method='post'>
                   <!--Start name field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>name</label>
                      <div class='col-sm-10'>
                        <input type='text' name='name' class='form-control'  autocomplete='off' required='required'/>
                      </div>
                    </div>
                    <!--End  name field-->
                    <!--Start description field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Description</label>
                      <div class='col-sm-10'>
                        <input type='text' name='description' class='password form-control' autocomplete='new-password' required='required'/>
                      </div>
                    </div>
                    <!--End description field-->
                    <!--Start ordering field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Ordering</label>
                      <div class='col-sm-10'>
                        <input type='text' name='ordering' class='form-control'/>
                      </div>
                    </div>
                    <!--End ordering field-->
                    <!--Start Visibilty field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Visible</label>
                      <div class='col-sm-10'>
                         <div>
                           <input id='visible-yes' type='radio' name='visibility' value='0' checked>
                           <label for='visible-yes'>Yes</label>
                         </div>
                         <div>
                           <input id='visible-no' type='radio' name='visibility' value='1'>
                           <label for='visible-no'>No</label>
                         </div>
                      </div>
                    </div>
                    <!--End Visibilty field-->
                    <!--Start Commenting field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Allow Comment</label>
                      <div class='col-sm-10'>
                         <div>
                           <input id='comment-yes' type='radio' name='commenting' value='0' checked>
                           <label for='comment-yes'>Yes</label>
                         </div>
                         <div>
                           <input id='comment-no' type='radio' name='commenting' value='1'>
                           <label for='comment-no'>No</label>
                         </div>
                      </div>
                    </div>
                    <!--End Commenting field-->
                    <!--Start ads field-->
                    <div class='form-group'>
                      <label class='col-sm-2 control-label'>Allow ads</label>
                      <div class='col-sm-10'>
                         <div>
                           <input id='ads-yes' type='radio' name='ads' value='0' checked>
                           <label for='ads-yes'>Yes</label>
                         </div>
                         <div>
                           <input id='ads-no' type='radio' name='ads' value='1'>
                           <label for='ads-no'>No</label>
                         </div>
                      </div>
                    </div>
                    <!--End ads field-->
                    <!--Start Submit Button-->
                    <div class='form-group'>
                      <div class='col-sm-offset-2 col-sm-10'>
                        <input type='submit' value='Add category' class='btn btn-success btn-block'/>
                      </div>
                    </div>
                    <!--End Submit Button-->
                </form>
             </div>
        ";//End echo for write HTMl at PHP code

    }elseif ($do=='insert'){//insert Category page
        if($_SERVER['REQUEST_METHOD']==='POST'){
            //get the variable form the Form
            $name =$_POST['name'];
            $desc =$_POST['description'];
            $order=$_POST['ordering'];
            $visible=$_POST['visibility'];
            $comment=$_POST['commenting'];
            $ads=$_POST['ads'];
            //Validate the form
            $formErrors=array();
            if (strlen($name) > 20){
                $formErrors[]='name must be less than 20 character';
            }
            if (empty($name)){
                $formErrors[]='name must not be empty';
            }
            if (strlen($desc) < 4) {
                $formErrors[] = 'desc must be more than 4 character';
            }
            if (empty($desc)){
                $formErrors[]='desc must not be empty';
            }

            foreach ($formErrors as $error){
                echo "<div class='alert alert-danger'>" .$error."</div>";
            }
            if(empty($formErrors)){
                // check if userinfo in database
                $check=checkItem("name" ,"categories" , $name);
                if($check == 1 ){
                    $theMsg = "<div class='alert alert-danger'>this Category is exist</div>";
                    redirectHome($theMsg , 'back');
                }else{
                    //Insert Category Info
                    $stmt=$con->prepare("INSERT INTO categories (Name ,Description, 	Ordering , Visibility ,Allow_Comment ,Allow_Ads) VALUES ( ? , ? , ? , ?, ? , ?)");
                    $stmt->execute(array($name , $desc , $order , $visible , $comment ,$ads));
                    $count=$stmt->rowCount();
                    $theMsg = '<div class="alert alert-success">'.$count .'Insert Record</div>';
                    redirectHome($theMsg , 'back');
                }
            }
        }else{
            $theMsg='<div class="alert alert-danger ">you cant browse page directly</div>';
            redirectHome($theMsg , 'back');
        }

    }
    include 'includes/templates/footer.inc';
}else{
    header('location:index.php');
}