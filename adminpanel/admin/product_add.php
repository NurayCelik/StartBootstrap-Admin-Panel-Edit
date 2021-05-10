<?php
include("includes/header.php");
include '../../classes/Product.php';
include '../../classes/Categories.php';
include_once '../../helpers/Format.php';
?>
<?php
$prod =  new Product();
$cat = new Categories();
$fm =  new Format();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addBtn'])) {
    $hot = @$_POST['isHotProduct'] == null ? 0 : 1;
    $new = @$_POST['isNewArrival'] == null ? 0 : 1;
    $insertedProd = $prod->InsertProduct($_POST, $_FILES, $hot, $new);
}

?>

<div class="container-fluid">

    <?php
    if (isset($insertedProd)) {
        echo  '<p class="mb-4">' . $insertedProd . '</p>';
    }

    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Product Veri Ekle </h6>
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
                        <label> Product Name </label>
                        <input type="text" required="required" name="name" class="form-control" placeholder="Başlık Yazınız">
                    </div>
                    <br>
                    <div class="form-group">
                        <label> Product Detail </label>
                        <textarea name="detail" id="" class="form-control" rows="10" required="required" placeholder="Ayrıntıları Yazınız"></textarea>
                    </div>

                    <br>
                    <div class="form-group">
                        <label> Product Price </label>
                        <input type="number" required="required" name="price" class="form-control" placeholder="Fiyat Yazınız">
                    </div>
                    <br>
                    <div class="form-group">
                        <label> Product Discount </label>
                        <input type="number" required="required" name="discount" class="form-control" placeholder="Ürün Adedi Yazınız">
                    </div>
                    <br>
                    <div class="form-group">
                        <label> Product Kategori Seç</label><br>
                        <select id="select" name="category" required="required" placeholder="Kategori adı seçiniz..." class="form-control col-md-7 col-xs-12">
                            <option>Select Kategori</option>
                            <?php
                            $getCat =  $cat->getAllCat();  // With this object i create some of he method.
                            if ($getCat) {
                                while ($value = $getCat->fetch_assoc()) {
                            ?>
                                    <!--id eklersek ceri tabanına value değeri  $value['catId'] yazardık. -->
                                    <option value="<?php echo $value['name'] . '+' . $value['catId']; ?>"><?php echo $value['name']; ?></option>

                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <label>Foto Yükle</label>
                        <input type="file" required="required" name="image" class="form-control" placeholder="Foto Seçiniz... ">
                    </div>
                    <br>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="isHotProduct" value="1">
                        <label class="form-check-label" for="exampleCheck1">Is Hot Product</label>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck2" name="isNewArrival" value="1">
                        <label class="form-check-label" for="exampleCheck2">Is New Arrival</label>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addBtn" class="btn btn-primary">
                        <i class="fas fa-plus-square"></i> Ekle </button>
                    <a href="product.php">
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