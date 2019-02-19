<?php
session_start();
if (isset($_SESSION['Username'])){
    $pageTitle='dashboard';
    include "init.inc";
  //Start echo to Write HTML AT PHP code
    echo '
            <div class="container home-stats text-center">
              <h1 class="text-center">Dashboard</h1>
              <div class="row"><!--start responsive class-->
                 <div class="col-md-3"> <!--Start Columns 1 class -->
                    <div class="stat st-members">
                     Total Members
                     <span><a href="member.php">'.countItems("UserID" , "users") .'</a></span>
                    </div>
                 </div><!--End Columns1 class -->
                 <div class="col-md-3"> <!--Start Columns2 class -->
                    <div class="stat st-pending">
                     pending Members
                     <span><a href="member.php?do=manage&page=pending">'.checkItem('Regstatus' ,'users', 0).'</a></span>
                    </div>
                 </div><!--End Columns2 class -->
                 <div class="col-md-3"> <!--Start Columns3 class -->
                    <div class="stat st-items">
                     Total Items
                     <span>200</span>
                    </div>
                 </div><!--End Columns3 class -->
                 <div class="col-md-3"> <!--Start Columns4 class -->
                    <div class="stat st-comments">
                     Total Comments
                     <span>200</span>
                    </div>
                 </div><!--End Columns4 class -->
              </div><!--End responsive class-->
            </div>
    ';
    echo '
           <div class="container latest">
              <div class="row">
                <div class="col-sm-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <i class="fa fa-users"></i>
                      <h4>Latest Regitsered users</h4>
                    </div>
                    <div class="panel-body">
                      <ul class="list-unstyled latest-users">';
                          $theLatest= getLatest("*" , "users" , "UserID" ,5);
                          foreach ($theLatest as $user){
                              echo "<li>"
                                  .$user['Username']
                                  ."<a href='member.php?do=edit&userid=".$user['UserID']."'>
                                     <span class='btn btn-success pull-right'><i class='fa fa-edit'></i> 
                                      Edit 
                                      </span>
                                    </a>  
                              </li>" ;
                             if ($user['RegStatus']==0){
                                 echo "<a href='member.php?do=activate&userid=".$user['UserID']. "'class='btn btn-info pull-right activate'>
                                         <i class='fa fa-plus'></i> Activate
                                       </a>";
                             }
                          }
    echo '            </ul>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <i class="fa fa-tag"></i>
                      <h4>Latest items</h4>
                    </div>
                    <div class="panel-body">Test</div>
                  </div>
                </div>
              </div>
           </div>
              
    ';
    //End echo to Write HTML AT PHP code
   include "includes/templates/footer.inc";
}else{
    header('location: index.php');
    exit();
}