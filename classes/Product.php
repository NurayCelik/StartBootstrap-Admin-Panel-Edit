<?php
$filepath = realpath(dirname(__FILE__)); //http://localhost/shop olan url kısım. daha kolay ulaşılsın diye yazıldı. Yoksa admin kısım rahat classlara ulaşırken diğer bölümler erişemiyor.
include_once($filepath . '/../datalib/Database.php');
include_once($filepath . '/../helpers/Format.php');

?>
 
<?php
class Product
{
  private $db;  // I crate Property for Database Class
  private $fm; // I crate Property for Format Class  

  public function __construct()
  {
    $this->db   = new Database(); // I crate Object for Database Class
    $this->fm   = new Format(); // I crate Object for Format Class  
  }



  public function getAllProduct()
  {
    $query = "SELECT * FROM product ORDER BY productId DESC ";
    $result =  $this->db->select($query);
    return $result;
  }

  public function getIdProductData($id)
  {
    $query = "SELECT * FROM product WHERE productId = '$id' ";
    $result =  $this->db->select($query);
    return $result;
  }
  public function deleteProd($id)
  {
    $this->delImageId($id, 'product', 'productId', 'image'); //Önce fotoyu silelim dosya yolunu kaybetmemek için
    $query = "DELETE FROM product WHERE productId ='$id' ";
    $deldata = $this->db->delete($query);
    if ($deldata) {
      $msg = "<span class='success' style='color:forestgreen;'>Product Data Silindi.</span> ";
      return $msg;
    } else {
      $msg = "<span class='error' style='color:red;'>Product Data Silinmedi.</span> ";
      return $msg;
    }
  }

  public function delImageId($id, $tableName, $tableId, $column)
  {
    $query = "SELECT * FROM $tableName WHERE $tableId ='$id' ";
    $getData = $this->db->select($query);
    if ($getData) {
      while ($delImg = $getData->fetch_assoc()) {

        $dellink = $delImg[$column];
        @unlink($dellink);
      }
    }
  }



  public function updateProduct($data, $files, $id, $hot, $new)
  {
    date_default_timezone_set('Europe/Istanbul');

    $list = explode('+', $data['category']);

    $name               =  mysqli_real_escape_string($this->db->link, addslashes(strip_tags($data['name'])));
    $price              =  mysqli_real_escape_string($this->db->link, ($data['price']));
    $discount           =  mysqli_real_escape_string($this->db->link, $data['discount']);
    $category           =  mysqli_real_escape_string($this->db->link, addslashes(strip_tags($list[0])));
    $catId              =  mysqli_real_escape_string($this->db->link, $list[1]);
    $isHotProduct       =  mysqli_real_escape_string($this->db->link, $hot);
    $isNewArrival       =  mysqli_real_escape_string($this->db->link, $new);
    $detail             =  mysqli_real_escape_string($this->db->link, addslashes(strip_tags($data['detail'])));
    $permited = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');

    $file_name  =  $files['image']['name'];
    $file_size  =  $files['image']['size'];
    $file_temp  =  $files['image']['tmp_name'];
    $file_type  =  $files['image']['type'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
    $uploaded_image = "../../uploads/product/" . substr(md5(uniqid(rand(1, 6))), 0, 8) . '.' . $unique_image;


    if (
      !isset($name)  || $name == "" || !isset($price)  || $price == "" ||
      !isset($discount) || $discount == "" || !isset($category) || $category == "" ||
      !isset($isHotProduct) || $isHotProduct == "" || !isset($isNewArrival) || $isNewArrival == ""
    ) {
      $msg = "<span class='error' style='color:red;'>Alanlar Boş Olmamalı!</span> ";
      return $msg;
    } else {

      try {

        if (!empty($file_name)) {

          if ($file_size > 1054589) {
            echo "<span class='error' style='color:red;'>Image Boyutu 1MB den fazla olmamalı!</span>";
          } elseif (in_array($file_ext, $permited) === false) {
            echo "<span class='error' style='color:red;'> Sadece şu uzantılı dosyaları yükleyebilirsiniz: " . implode(',', $permited) . "</span>";
          } else {


            $columnName = 'image';
            $tName = 'product';
            $columnId = 'productId';
            $this->delImageId($id, $tName, $columnId, $columnName);
            move_uploaded_file($file_temp, $uploaded_image);

            $query = "UPDATE product
            SET
              name           = '$name',
              price          = '$price',
              discount       = '$discount',
              catId          = '$catId',
              category       = '$category',
              image          = '$uploaded_image',
              detail         = '$detail',
              isHotProduct   = '$isHotProduct',
              isNewArrival   = '$isNewArrival'
            WHERE productId = '$id' ";
            $updated_row = $this->db->update($query);
            if ($updated_row) {
              $msg = "<span class='success' style='color:forestgreen;'>Product Data Güncellendi.</span> ";
              header("refresh:5; url=product.php");
              return $msg;
            } else {
              $msg = "<span class='error' style='color:red;'>Product Data Güncellenmedi!</span> ";
              return $msg;
            }
          }
        } else {
          $query = "UPDATE product
        SET 
          name           = '$name',
          price          = '$price',
          discount       = '$discount',
          catId          = '$catId',
          category       = '$category',
          detail         = '$detail',
          isHotProduct   = '$isHotProduct',
          isNewArrival   = '$isNewArrival'
        WHERE productId = '$id' ";
          $updated_row = $this->db->update($query);
          if ($updated_row) {
            $msg = "<span class='success' style='color:forestgreen;'>Product Data Güncellendi.</span> ";
            header("refresh:5; url=product.php");
            return $msg;
          } else {
            $msg = "<span class='error' style='color:red;'>Product Data Güncellenmedi!</span> ";
            return $msg;
          }
        }
      } catch (Exception $e) {
        die($e->getMessage());
      }
    }
  }



  public function insertProduct($data, $files, $hot, $new)
  {

    date_default_timezone_set('Europe/Istanbul');

    $list = explode('+', $data['category']);

    $name               =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['name'])));
    $price              =  mysqli_real_escape_string($this->db->link, ($data['price']));
    $discount           =  mysqli_real_escape_string($this->db->link, $data['discount']);
    $category           =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($list[0])));
    $catId              =  mysqli_real_escape_string($this->db->link, $list[1]);
    $isHotProduct       =  mysqli_real_escape_string($this->db->link, $hot);
    $isNewArrival       =  mysqli_real_escape_string($this->db->link, $new);
    $detail             =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['detail'])));

    $permited = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');

    $file_name  =  $files['image']['name'];
    $file_size  =  $files['image']['size'];
    $file_temp  =  $files['image']['tmp_name'];
    $file_type  =  $files['image']['type'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
    $inserted_image = "../../uploads/product/" . $unique_image;

    if (
      !isset($name)  || $name == "" || !isset($price)  || $price == "" ||
      !isset($discount) || $discount == "" || !isset($category) || $category == "" ||
      !isset($isHotProduct) || $isHotProduct == "" || !isset($isNewArrival) || $isNewArrival == ""
    ) {
      $msg = "<span class='error' style='color:red;'>Alanlar Boş Olmamalı!</span> ";
      return $msg;
    } else {

      try {

        if (!empty($file_name)) {

          if ($file_size > 1054589) {
            echo "<span class='error' style='color:red;'>Image Boyutu 1MB den fazla olmamalı!</span>";
          } elseif (in_array($file_ext, $permited) === false) {
            echo "<span class='error' style='color:red;'> Sadece şu uzantılı dosyaları yükleyebilirsiniz: " . implode(',', $permited) . "</span>";
          } else {

            move_uploaded_file($file_temp, $inserted_image);

            $query = "INSERT INTO 
          product(name, price, discount, catId, category, image, detail, isHotProduct, isNewArrival) 
          VALUES ('$name', '$price','$discount','$catId', '$category', '$inserted_image', '$detail', '$isHotProduct', '$isNewArrival')";

            $inserted_row = $this->db->insert($query);
            if ($inserted_row) {

              $msg = "<span class='success' style='color:forestgreen;'>Product Data Eklendi.</span> ";
              header("refresh:3; url=product.php");
              return $msg; // return message 
            } else {
              $msg = "<span class='error' style='color:red;'>Product Data Eklenmedi!</span> ";
              return $msg; // return message 
            }
          }
        }
      } catch (Exception $e) {
        die($e->getMessage());
      }
    }
  }
}
