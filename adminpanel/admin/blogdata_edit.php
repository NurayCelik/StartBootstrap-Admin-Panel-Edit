<?php
include("includes/header.php");

include '../../classes/Blog.php';
include '../../classes/Category.php';
include_once '../../helpers/Format.php';
?>
<?php 
  $bl =  new Blog();
  $fm =  new Format();
  $cat = new Category();

  if (!($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editBtn'])) ) { 
    echo "<script>window.location = 'blogdata.php';  </script>"; 
    }else {
        $id = $_POST['editId'];
     }
 
/*   
//get ile a href ile gelseydi id bu şekilde yazılır
if(!isset($_GET['editId'])  || $_GET['editId'] == NULL ) {
        echo "<script>window.location = 'blogdata.php';  </script>";
     }else {
        $id = $_GET['editId'];
     } */

 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatebtn'])){ 
      $idn = $_POST['formId'];
      $editedBlog = $bl->updateBlog($_POST, $_FILES, $idn);
  }

 ?>
<div class="container-fluid" style="font-size:.79rem">

    <?php 
            if(isset($editedBlog)) {
                echo  '<p class="mb-4">'.$editedBlog.'</p>';
            }
            
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> EDIT BLOG DATA </h6>
        </div>
        <div class="card-body">

        <?php
          
           $blogData = $bl->getIdBlogData(@$id); // Create this method in our User.php Class
           if($blogData) {
            while ($value = $blogData->fetch_assoc()) { 
       ?> 

        <form action="" method="POST" enctype="multipart/form-data" data-parsley-validate>
            <style>
            label{
                font-weight:bold;}
            </style>
        <div class="modal-body">

            <div class="form-group">
                <label> Başlık </label>
                <br>
                <input type="text" required="required" name="title" class="form-control" 
                value="<?php  echo $fm->validation($value['title']); ?>">
            </div>
            <br>
            <br>
            <div class="form-group">
                <label>Kategori</label><br>
                <select id="select" name="catId" required="required" placeholder="Kategori adını seçiniz..." class="form-control col-md-7 col-xs-12">
                        
                    <?php
                        $getCat =  $cat->getAllCat();  // With this object i create some of he method.
                            if ($getCat) {
                            while ($result = $getCat->fetch_assoc()) {
                    ?>
                <option <?php 

                if ($value['catId'] == $result['catId']) {
                 ?>
                selected = "selected"
                <?php 
                    }  
                ?> 
                value="<?php echo $result['catId'];  ?>" > <?php echo $result['catName']; ?>
                <?php   
                    }  
                    } 
                ?>
                </option>
                </select>
            </div>
            <br>
            <br>
            <div class="form-group">
                <label> Detay </label><br>
                <textarea name="details" id="editor1" class="form-control col-md-12 col-xs-12 ckeditor" rows="10" required="required" ><?php  echo $fm->validation($value['details']); ?></textarea>
            </div>
            <script type="text/javascript">


                   CKEDITOR.replace( 'editor1',
                   {
                    filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
                    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
                    filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                    forcePasteAsPlainText: true
                  } 
                  );
            </script>
            <br>
            <br>
            <div class="form-group">
                <label>Eski Tarih : <?php echo $fm->validation($fm->formatDateOnly($value['blogDate'])); ?></label><br>
                <label>Yeni Tarih Seçiniz : </label>
                <input type="date" required="required" name="blogDate" class="form-control col-md-7 col-xs-12" 
                value="<?php echo $fm->validation($fm->formatDateOnly($value['blogDate'])); ?>">
            </div>
            <br>
            <br>
            <div class="form-group">
               <label> Eski Link Foto </label><br>
               <img width="300" height="200"
               <?php
               
               if(strlen($fm->validation($value['featuredImageUrl']))>0)
               {
                   echo 'src="'.$value['featuredImageUrl'].'">';
               }
               else{
                echo 'src="../../uploads/noimage.png">';
               }
               
               ?>
               </div>
               <br>
            <div class="form-group">
                <label> Yeni Link :</label><br>
                <input type="text" required="required" name="featuredImageUrl" class="form-control" 
                value="<?php  echo $fm->validation($value['featuredImageUrl']); ?>">
            </div>
            <br>
            <hr>
            <br>
            <div class="form-group">
               <label> Eski Foto </label><br>
               <img width="300" height="200"
               <?php
               if(strlen($fm->validation($value['myImage']))>0)
               {
                   echo 'src="'.$value['myImage'].'">';
               }
               else{
                echo 'src="../../uploads/noimage.png">';
               }
               
               ?>
               </div>
               <br>
            
            <div class="form-group">
               <label> Foto Seç : </label><br>
               <input type="file" name="myImage"/>
            </div>
            <div class="form-group">
               <input type="hidden" name="formId" value="<?php echo $fm->validation($value['id']); ?>">
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