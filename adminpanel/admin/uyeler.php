<?php
include("includes/header.php");
?>

<?php
include '../../classes/User.php';
include_once '../../helpers/Format.php';
?>
<?php
$ad =  new User();
$fm =  new Format();




?>




<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Yöneticiler
                <button type="button" style="float:right;" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
                    <i class="fas fa-plus-square"></i> Yönetici
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
                        </tr>
                    </thead>

                    <tfoot>
                        <!-- En Alt satırda da başlıklar cıkacak -->
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">UserName</th>
                            <th class="text-center">Email</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        <?php
                        $userData = $ad->getUserData(); // Create this method in our User.php Class
                        if ($userData) {
                            $i = 0;
                            while ($value = $userData->fetch_assoc()) {
                                $i++;
                        ?>
                                <td class="text-center"><?php echo $i; ?></td>
                                <td class="text-center"><?php echo $fm->validation($value['userName']); ?></td>
                                <td class="text-center"><?php echo $fm->validation($value['userEmail']); ?></td>

                                </tr>
                        <?php
                            }
                        } else {
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