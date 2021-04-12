<?php
include("includes/header.php");

include '../../classes/Category.php';
include_once '../../helpers/Format.php';
?>
<?php 
  $cat =  new Category();
  $fm =  new Format();

 
  if (!($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editBtn'])) ) { 
    echo "<script>window.location = 'category.php';  </script>"; 
    }else {
        $id = $_POST['editId'];
  
     }
 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatebtn'])){ 
      $idn = $_POST['formId'];
      $editedCat = $cat->catUpdate($_POST, $idn);
  }

 ?>
<div class="container-fluid" style="font-size:.79rem">

    <?php 
            if(isset($editedCat)) {
                echo  '<p class="mb-4">'.$editedCat.'</p>';
            }
            
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> EDIT Categori </h6>
        </div>
        <div class="card-body">

        <?php
          
           $catData = $cat->getCatById(@$id); // Create this method in our User.php Class
           if($catData) {
            while ($value = $catData->fetch_assoc()) { 
       ?> 

        <form action="" method="POST" id="">

        <div class="modal-body">

            <div class="form-group">
                <label> Categori AAd </label>
                <input type="text" required="required" name="catName" class="form-control" 
                value="<?php  echo $fm->validation($value['catName']); ?>">
            </div>
            
            <div class="form-group">
               <input type="hidden" name="formId" value="<?php echo $fm->validation($value['catId']); ?>">
            </div>
         </div>
        <div class="modal-footer">
            <button type="submit" name="updatebtn" class="btn btn-primary">
            <span class="icon text-white"><i class="fas fa-edit" aria-hidden="true"></i> Update</span></button>
            <a href="<?php echo $_SERVER['PHP_SELF'];?>">
            <button type="button" class="btn btn-info" data-dismiss="modal">
            <i class="fas fa-undo"></i>  Cancel </button></a>
            
        </div>
        </form>

        <?php
                 
            }
        }
        ?>
        
        </div>
    </div>
</div>


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