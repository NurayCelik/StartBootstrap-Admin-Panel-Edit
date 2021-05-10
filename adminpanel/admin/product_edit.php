<?php
include("includes/header.php");

include '../../classes/Product.php';
include '../../classes/Categories.php';
include_once '../../helpers/Format.php';
?>
<?php
$prod =  new Product();
$fm   =  new Format();
$cat  = new Categories();

if (!($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editBtn']))) {
    echo "<script>window.location = 'product.php';  </script>";
} else {
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
    $hot = @$_POST['isHotProduct'] == null ? 0 : 1;
    $new = @$_POST['isNewArrival'] == null ? 0 : 1;
    $editedProd = $prod->updateProduct($_POST, $_FILES, $idn, $hot, $new);
}

?>
<div class="container-fluid" style="font-size:.79rem">

    <?php
    if (isset($editedProd)) {
        echo  '<p class="mb-4">' . $editedProd . '</p>';
    }

    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> EDIT PRODUCT DATA </h6>
        </div>
        <div class="card-body">

            <?php

            $prodData = $prod->getIdProductData(@$id); // Create this method in our User.php Class
            if ($prodData) {
                while ($value = $prodData->fetch_assoc()) {
            ?>

                    <form action="" method="POST" enctype="multipart/form-data" data-parsley-validate>
                        <style>
                            label {
                                font-weight: bold;
                            }
                        </style>
                        <div class="modal-body">

                            <div class="form-group">
                                <label> Product Name </label>
                                <br>
                                <input type="text" name="name" class="form-control" value="<?php echo $fm->validation($value['name']); ?>">
                            </div>
                            <br>
                            <div class="form-group">
                                <label> Product Detail </label>
                                <textarea name="detail" id="" class="form-control " rows="10" required="required"><?php echo $fm->validation($value['detail']); ?></textarea>
                            </div>

                            <br>
                            <div class="form-group">
                                <label> Product Price </label>
                                <input type="number" value="<?php echo $fm->validation($value['price']); ?>" required="required" name="price" class="form-control" placeholder="Fiyat Yazınız">
                            </div>
                            <br>
                            <div class="form-group">
                                <label> Product Discount </label>
                                <input type="number" value="<?php echo $fm->validation($value['discount']); ?>" required="required" name="discount" class="form-control" placeholder="Ürün Adedi Yazınız">
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Kategori</label><br>
                                <select id="select" name="category" placeholder="Kategori adını seçiniz..." class="form-control col-md-7 col-xs-12">

                                    <?php
                                    $getCat =  $cat->getAllCat();  // With this object i create some of he method.
                                    if ($getCat) {
                                        while ($result = $getCat->fetch_assoc()) {
                                    ?>
                                            <option <?php

                                                    if ($value['category'] == $result['name']) {
                                                    ?> selected="selected" <?php
                                                                        }
                                                                            ?> value="<?php echo $result['name'] . '+' . $result['catId'];  ?>"> <?php echo $result['name']; ?>
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
                                <label> Eski Foto </label><br>
                                <img width="300" height="200" <?php
                                                                if (strlen($fm->validation($value['image'])) > 0) {
                                                                    echo 'src="' . $value['image'] . '">';
                                                                } else {
                                                                    echo 'src="../../uploads/noimage.png">';
                                                                }

                                                                ?> />
                            </div>
                            <br>

                            <div class="form-group">
                                <label> Foto Seç : </label><br>
                                <input type="file" name="image" />
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="formId" value="<?php echo $fm->validation($value['productId']); ?>">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" <?php if ($fm->validation($value['isHotProduct'] == 1)) {
                                                                                                        echo "checked='checked'";
                                                                                                    } else echo ''; ?> name="isHotProduct" value="<?php echo $fm->validation($value['isHotProduct']); ?>">
                                <label class="form-check-label" for="exampleCheck1">Is Hot Product</label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck2" <?php if ($fm->validation($value['isNewArrival'] == 1)) {
                                                                                                        echo "checked='checked'";
                                                                                                    } else echo ''; ?> name="isNewArrival" value="<?php echo $fm->validation($value['isNewArrival']); ?>">
                                <label class="form-check-label" for="exampleCheck1">Is New Arrival</label>
                            </div>
                            <br>
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