<?php
include("includes/header.php");
?>

<?php 
include '../../classes/User.php';
include_once '../../helpers/Format.php';
?>
<?php 
  $us =  new User();
  $fm =  new Format();

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registerbtn']) ) { 
       
             $insertedAdmin = $us->adminInsert($_POST);
      
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteBtn']) ) { 
       
        $id = $_POST['deleteId'];
        $deletedAdmin = $us->deleteUser($id);
 
    }
   

?> 


<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>?id=#backRegister" method="POST" id="backRegister">

        <div class="modal-body">

            <div class="form-group">
                <label> Username </label>
                <input type="text" name="username" class="form-control" placeholder="Enter Username">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="useremail" name="useremail" class="form-control checking_email" placeholder="Enter Email">
                <small class="error_email" style="color: red;"></small>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <label>User Type</label>
                <input type="text" name="usertype" class="form-control" placeholder="Enter Usertype">
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="registerbtn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="container-fluid">
<?php 
                  if(isset($insertedAdmin)) {
                       echo  '<p class="mb-4">'.$insertedAdmin.'</p>';
                    }
                    if(isset($deletedAdmin)) {
                        echo  '<p class="mb-4">'.$deletedAdmin.'</p>';
                     }
?>

 <!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Users
        <button type="button"  style="float:right;" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
        <i class="fas fa-plus-square"></i> User
        </button>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">UserName</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">UserType</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Delete</th>
                    </tr>
                </thead>
                
                <tfoot><!-- En Alt satırda da başlıklar cıkacak -->
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">UserName</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">UserType</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Delete</th>
                    </tr>
                </tfoot>
                <tbody>

                <?php 
                $adminData = $us->getAdminData(); // Create this method in our User.php Class
                if ($adminData) {
                    $i =0 ;
                while ($value = $adminData->fetch_assoc()) { 
                    $i++;
                ?> 
                <td class="text-center"><?php echo $i; ?></td>
                <td class="text-center"><?php echo $fm->validation($value['username']); ?></td>
                <td class="text-center"><?php echo $fm->validation($value['useremail']); ?></td>
                <td class="text-center"><?php echo $fm->validation($value['usertype']); ?></td>


                <td class="text-center">
                    <form action="register_edit.php" method="post">
                        <input type="hidden" name="editId" value="<?php echo $fm->validation($value['id']); ?>">
                        <button type="submit" name="editBtn" class="btn btn-success"> EDIT</button>
                    </form>
                </td>
                <td class="text-center">
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <input type="hidden" name="deleteId" value="<?php echo $fm->validation($value['id']); ?>">
                        <button onclick="return confirm('Are you sure to delete')" 
                        type="submit" name="deleteBtn" class="btn btn-danger"> DELETE</button>
                    </form>
                </td>
                </tr>
                    <?php
                      } 
                        }
                        else {
                            echo "Kayıt Bulunamadı!";
                        } 
                ?>
                </tbody>
            </table>

        </div>
    </div>
  </div>
  </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->         
 
                </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->       
    </div>
    <!-- End of Content Wrapper -->

 </div>
    <!-- End of Page Wrapper -->  
 
                  



<?php
include("includes/footer.php");
?>