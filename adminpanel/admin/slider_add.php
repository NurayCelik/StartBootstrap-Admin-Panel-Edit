<?php
include("includes/header.php");
include '../../classes/Slider.php';
include_once '../../helpers/Format.php';
?>
<?php
$slid =  new Slider();
$fm   =  new Format();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addBtn'])) {
    $insertedSlid = $slid->insertSlider($_POST, $_FILES);
}

?>

<div class="container-fluid">

    <?php
    if (isset($insertedSlid)) {
        echo  '<p class="mb-4">' . $insertedSlid . '</p>';
    }

    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Slide Data Ekle </h6>
        </div>
        <div class="card-body">



            <form action="" method="POST" enctype="multipart/form-data" data-parsley-validate>
                <style>
                    label {
                        font-weight: bold;
                    }
                </style>
                <div class="modal-body">

                    <div class="form-group">
                        <label> Slider Başlık </label>
                        <input type="text" required="required" name="title" class="form-control" placeholder="Başlık Yazınız">
                    </div>
                    <br>
                    <div class="form-group">
                        <label> Slider Message </label>
                        <input type="text" required="required" name="message" class="form-control" placeholder="Mesaj Yazınız">
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Foto Yükle</label>
                        <input type="file" required="required" name="image" class="form-control" placeholder="Foto Seçiniz... ">
                    </div>
                   <br>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="addBtn" class="btn btn-primary">
                            <i class="fas fa-plus-square"></i> Ekle </button>
                        <a href="slider.php">
                            <button type="button" class="btn btn-info" data-dismiss="modal">
                                <i class="fas fa-undo"></i> Vazgeç </button></a>
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