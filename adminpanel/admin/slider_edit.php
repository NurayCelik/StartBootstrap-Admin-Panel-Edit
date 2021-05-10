<?php
include("includes/header.php");

include '../../classes/Slider.php';
include_once '../../helpers/Format.php';
?>
<?php
$slid =  new Slider();
$fm   =  new Format();

   if (!($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editBtn'])) ) { 
     echo "<script>window.location = 'slider.php';  </script>"; 
     }else {
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editBtn'])) {
    $id = $_POST['editId'];
}
}

/*   
//get ile a href ile gelseydi id bu şekilde yazılır
if(!isset($_GET['editId'])  || $_GET['editId'] == NULL ) {
        echo "<script>window.location = 'blogdata.php';  </script>";
     }else {
        $id = $_GET['editId'];
     } */

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatebtn'])) {
    $idn = $_POST['formId'];
    $editedSlid = $slid->updateSlider($_POST, $_FILES, $idn);
}

?>
<div class="container-fluid" style="font-size:.79rem">

    <?php
    if (isset($editedSlid)) {
        echo  '<p class="mb-4">' . $editedSlid . '</p>';
    }

    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> SLIDER PRODUCT DATA </h6>
        </div>
        <div class="card-body">

            <?php

            $slidData = $slid->getSliderById(@$id); // Create this method in our User.php Class
            if ($slidData) {
                while ($value = $slidData->fetch_assoc()) {
            ?>

                    <form action="" method="POST" enctype="multipart/form-data" data-parsley-validate>
                        <style>
                            label {
                                font-weight: bold;
                            }
                        </style>
                        <div class="modal-body">

                            <div class="form-group">
                                <label> Slider Başlık </label>
                                <br>
                                <input type="text" name="title" class="form-control" value="<?php echo $fm->validation($value['title']); ?>">
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <label> Slider Mesaj </label>
                                <input type="text" value="<?php echo $fm->validation($value['message']); ?>" required="required" name="message" class="form-control">
                            </div>
                            <br>
                            <div class="form-group">
                                <label> Eski Foto </label><br>
                                <img width="300" height="200" <?php
                                                                if (strlen($fm->validation($value['image'])) > 0) {
                                                                    echo 'src="' . $value['image'] . '">';
                                                                } else {
                                                                    echo 'src="../../uploads/noimage.png">';
                                                                }

                                                                ?> </div>
                                <br>

                                <div class="form-group">
                                    <label> Foto Seç : </label><br>
                                    <input type="file" name="image" />
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="formId" value="<?php echo $fm->validation($value['sliderId']); ?>">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" name="updatebtn" class="btn btn-primary">
                                    <span class="icon text-white"><i class="fas fa-edit" aria-hidden="true"></i> Update</span></button>
                                <a href="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <button type="button" class="btn btn-info" data-dismiss="modal">
                                        <i class="fas fa-undo"></i> Cancel </button></a>

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