<?php
include("includes/header.php");
?>

<?php 
include '../../classes/Category.php';
include_once '../../helpers/Format.php';
?>
<?php 
  $cat =  new Category();
  $fm =  new Format();

  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST))
    {
     
      switch(true){

        case $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['catBtn']): 
            $insertedCat = $cat->catInsert($_POST);
            break;
        case $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteBtn']): 
            $id = $_POST['deleteId'];
            $deletedCat = $cat->deleteCat($id);
            break;
       
        default :
        echo "";
    }
  }
   

?> 
<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>?id=#backCategory" method="POST" id="backCategory">

        <div class="modal-body">

            <div class="form-group">
                <label> Category Name </label>
                <input type="text" name="catName" class="form-control" placeholder="Enter Category">
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="catBtn" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Begin Page Content -->
<div class="container-fluid" style="font-size:.79rem">
<?php 
                  if(isset($insertedCat)) {
                       echo  '<p class="mb-4">'.$insertedCat.'</p>';
                  }
                  if(isset($deletedCat)) {
                    echo  '<p class="mb-4">'.$deletedCat.'</p>';
                 }
                    
                 
                 ?>
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Category
        <button style="float:right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategory">
        <i class="fas fa-plus-square"></i>  Category</button>
        </h6>
    </div>
<div class="card-body">
    <div class="table-responsive">
    
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="text-center">No </th>
                <th class="text-center">Category Name</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
            </tr>
        </thead>
        <tfoot><!-- En Alt satırda da başlıklar cıkacak -->
            <tr>
                <th class="text-center">No </th>
                <th class="text-center">Category Name</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
            </tr>
        </tfoot>
        <tbody>
       
        <?php 
        $catData = $cat->getAllCat(); // Create this method in our User.php Class
        if ($catData) {
            $i =0 ;
        while ($value = $catData->fetch_assoc()) { 
            $i++;
        ?> 
            <tr>
                <td class="sorting_1 tdStyle"><?php echo $i; ?></td>
                <td class="tdStyle"><?php echo $fm->validation($value['catName']); ?></td>
                <td class="tdStyle">
                <style>
                  .tdStyle{
                  vertical-align:middle !important;
                  align-items:center;
                  text-align:center;     
                    }
                  
                @media only screen and (max-width: 1136px)
                {
                 .customSize
                  {
                    width:100px !important;
                    
                    }
                    }
                    @media only screen and (max-width: 1421px)
                    {
                      .customSize
                      {
                        margin-right: 30px !important;
                      }
                {
                </style>
                
                <form action="categori_edit.php" class="customSize" style=" margin-left: 30px" method="post">    
                    <input type="hidden" name="editId" value="<?php echo $fm->validation($value['catId']); ?>">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <button type="submit" name="editBtn" style="font-size:.79rem;" class="btn btn-info ">
                    <span class="icon text-white"><i class="fas fa-edit"></i>  Düzenle</span></button>
                </form>
                </td>
                <td class="tdStyle">
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                    <input type="hidden" name="deleteId" value="<?php echo $fm->validation($value['catId']); ?>">
                    <button type="submit" name="deleteBtn" onclick="return confirm('Silmek istediğinizden emin misiniz?')" 
                    style="font-size:.79rem;" class="btn btn-danger">
                    <span class="icon text-white"><i class="fa fa-trash" aria-hidden="true"></i>  Sil</span></button> 
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
    <!-- End of Content Wrapper -->

 </div>
    <!-- End of Page Wrapper -->  
 

<?php
include("includes/footer.php");
?>