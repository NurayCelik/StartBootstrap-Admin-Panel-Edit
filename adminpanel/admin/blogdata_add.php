<?php
include("includes/header.php");
include '../../classes/Blog.php'; 
include '../../classes/Category.php';
include_once '../../helpers/Format.php';
?>
<?php 
  $bl =  new Blog();
  $cat = new Category();
  $fm =  new Format();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addBtn'])){ 
    $insertedBlog = $bl->InsertBlog($_POST, $_FILES);
}

 ?>

<div class="container-fluid">

    <?php 
            if(isset($insertedBlog)) {
                echo  '<p class="mb-4">'.$insertedBlog.'</p>';
            }
            
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Blog Veri Ekle </h6>
        </div>
        <div class="card-body">
       
   

    <form action="" method="POST"  enctype="multipart/form-data" data-parsley-validate >
    <style>
        label{
            font-weight:bold;
            }
      </style>
        <div class="modal-body">

            <div class="form-group">
                <label> Başlık </label>
                <input type="text" required="required" name="title" class="form-control" placeholder="Başlık Yazınız">
            </div>
            <br>
            <div class="form-group">
                <label>Kategori</label><br>
                <select id="select" name="catId" required="required" placeholder="Kategori adı seçiniz..." class="form-control col-md-7 col-xs-12">
                  <option>Select Kategori</option>      
                    <?php
                        $getCat =  $cat->getAllCat();  // With this object i create some of he method.
                            if ($getCat) {
                            while ($value = $getCat->fetch_assoc()) {
                    ?>
                <option value= "<?php echo $value['catId'];  ?>" ><?php echo $value['catName']; ?></option>
                    <?php 
                        }
                    }  
                ?> 
                </select>
            </div>
            <br>
            <div class="form-group">
                <label>Detay </label>
                <textarea name="details" id="editor1" class="form-control col-md-12 col-xs-12 ckeditor" rows="10" required="required" ></textarea>
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
            <div class="form-group">
                <label>Tarih</label>
                <input type="date" name="blogDate" class="form-control col-md-7 col-xs-12"" placeholder="Enter Date">
            </div>
            <br>
            <div class="form-group">
                <label>Foto Url</label>
                <input type="text" required="required" name="featuredImageUrl" class="form-control" placeholder="Link yazınız...">
            </div>
            <br>
            <div class="form-group">
                <label>Foto Yükle</label>
                <input type="file" required="required" name="myImage" class="form-control"  placeholder="Foto Seçiniz... ">
            </div>
            </div>
            <div class="modal-footer">
            <button type="submit" name="addBtn" class="btn btn-primary">
            <i class="fas fa-plus-square"></i> Ekle </button>
            <a href="blogdata.php">
            <button type="button" class="btn btn-info" data-dismiss="modal">
            <i class="fas fa-undo"></i>  Vazgeç </button></a>
            </div>
    </form>
                       
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