<?php
include("includes/header.php");
?>

<?php 
include '../../classes/Blog.php';
include_once '../../helpers/Format.php';
?>
<?php 
  $bl =  new Blog();
  $fm =  new Format();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteBtn'])){
    $id = $_POST['deleteId'];
    $deletedblog = $bl->deleteBlog($id);
}
?> 

<!-- Begin Page Content -->
<div class="container-fluid" style="font-size:.75rem">
<?php 
      if(isset($deletedblog)) {
          echo  '<p class="mb-4">'.$deletedblog.'</p>';
        }
?>
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Blog Data
        <a href="blogdata_add.php">
            <button style="float:right;" type="submit" class="btn btn-primary">
        <i class="fas fa-plus-square"></i>  Blog</button></a>
        </h6>
    </div>
<div class="card-body">
    <div class="table-responsive textSize">
    
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Başlık</th>
              <th class="text-center">Kategori</th>
              <th class="text-center">Detay</th>
              <th class="text-center" >Tarih</th>
              <th class="text-center">İmage</th>
              <th class="text-center">Delete</th>
              <th class="text-center">Edit</th>
            </tr>
        </thead>
        <tfoot><!-- En Alt satırda da başlıklar cıkacak -->
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Başlık</th>
              <th class="text-center">Kategori</th>
              <th class="text-center">Detay</th>
              <th class="text-center">Tarih</th>
              <th class="text-center">İmage</th>
              <th class="text-center">Delete</th>
              <th class="text-center">Edit</th>
              
            </tr>
        </tfoot>
        <tbody>
       
        <?php 
        $blogData = $bl->getAllBlog(); // Create this method in our User.php Class
        if ($blogData) {
            $i =0 ;
        while ($value = $blogData->fetch_assoc()) { 
            $i++;
        ?> 
            <tr>
           
                <td class="sorting_1 tdStyle"><?php echo $i; ?></td>
                <td class="tdStyle"><?php echo $fm->validation($value['title']); ?></td>
                <td class="tdStyle""><?php echo $fm->validation($value['catName']); ?></td>
                <td class="tdStyle"><?php echo $fm->validation($fm->textShorten($value['details'], 30)); ?></td>
                <td class="tdStyle"><?php echo $fm->validation($fm->formatDateOnly($value['blogDate'])); ?></td>
                <td class="tdStyle"><img width="80" height="60" src="<?php echo $value['featuredImageUrl']; ?>"></td>
                <td class="tdStyle">
                <style>
                 .tdStyle{
                  vertical-align:middle !important;
                  align-items:center;
                  text-align:center;     
                    }
                </style>
                <form action="blogdata_edit.php" 
                class="" method="post">
                    <input type="hidden" name="editId" value="<?php echo $fm->validation($value['id']); ?>">
                    <button type="submit" name="editBtn" style="font-size:.75rem;width:90px;" class="btn btn-info">
                    <span class="icon text-white"><i class="fas fa-edit" aria-hidden="true"></i>  Düzenle</span></button> 
                </form>
                </td>
                 <td class="tdStyle">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" 
                class="" method="post">
                    <input type="hidden" name="deleteId" value="<?php echo $fm->validation($value['id']); ?>">
                    <button type="submit" name="deleteBtn" onclick="return confirm('Are you sure to delete')"
                     style="font-size:.75rem; width:60px" class="btn btn-danger">
                    <span class="icon text-white"><i class="fas fa-trash" aria-hidden="true"></i>  Sil</span></button> 
                </form>
                </td> 
               <!--  <td style="vertical-align:middle;">
                <a href="?deleteId=<?php echo $fm->validation($value['id']); ?>" onclick="return confirm('Silmek istediğinizden emin misiniz?')">
                  <button type="submit" name="deleteBtn" style="font-size:.75rem; width:70px" class="btn btn-danger">
                  <span class="icon text-white"><i class="fas fa-trash" aria-hidden="true"></i>  Sil</span></button></a>
                 </td> -->
            </tr>
            <?php
        }
      }else {
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