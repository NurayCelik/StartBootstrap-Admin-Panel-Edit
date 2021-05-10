<?php

$filepath = realpath(dirname(__FILE__)); //http://localhost/shop olan url kısım. daha kolay ulaşılsın diye yazıldı. Yoksa admin kısım rahat classlara ulaşırken diğer bölümler erişemiyor.
include_once($filepath . '/../datalib/Database.php');
include_once($filepath . '/../helpers/Format.php');
?>

<?php
class Categories
{
  private $db; // Create one Property for Database Class
  private $fm; // Create one Property for Format Class

  public function __construct()
  {
    $this->db   = new Database(); // Create one Object for Database Class
    $this->fm   = new Format(); // Create one Property for Object Class
  }
  public function catInsert($data, $files)
  {
    $name        =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['name'])));

    $permited = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');

    $file_name  =  $files['myicon']['name'];
    $file_size  =  $files['myicon']['size'];
    $file_temp  =  $files['myicon']['tmp_name'];
    $file_type  =  $files['myicon']['type'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
    $inserted_image = "../../uploads/category/" . $unique_image;

    if (!isset($name)  || $name == "") {
      $msg = "<span class='error'>Alanlar Boş Olmamalı!</span> ";
      return $msg;
    } else {
      try {

        if (!empty($file_name)) {

          if ($file_size > 1054589) {
            echo "<span class='error'>Image Boyutu 1MB den fazla olmamalı!</span>";
          } elseif (in_array($file_ext, $permited) === false) {
            echo "<span class='error'> Sadece şu uzantılı dosyaları yükleyebilirsiniz: " . implode(',', $permited) . "</span>";
          } else {

            move_uploaded_file($file_temp, $inserted_image);

            $query = "INSERT INTO category(name, icon) 
        VALUES ('$name', '$inserted_image')";

            $inserted_row = $this->db->insert($query);
            if ($inserted_row) {
              $msg = "<span class='success' style='color:forestgreen;'>Categori eklendi.</span> ";
              header("refresh:3; url=category.php");
              return $msg; // return message 
            } else {
              $msg = "<span class='error' style='color:red;'>Categori eklenmedi.</span> ";
              return $msg; // return message 
            }
          }
        }
      } catch (Exception $e) {
        die($e->getMessage());
      }
    }
  }
 
  public function getAllCat()
  {
    $query = "SELECT * FROM category ORDER BY catId DESC";
    $result = $this->db->select($query);
    return $result;
  }
  public function getCatById($id)
  {
    $query = "SELECT * FROM category WHERE catId ='$id' ";
    $result = $this->db->select($query);
    return $result;
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
  public function catUpdate($data, $files, $id)
  {
    $name       =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['name'])));
    $permited   = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');

    $file_name  =  $files['myicon']['name'];
    $file_size  =  $files['myicon']['size'];
    $file_temp  =  $files['myicon']['tmp_name'];
    $file_type  =  $files['myicon']['type'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
    $uploaded_image = "../../uploads/category/" . substr(md5(uniqid(rand(1, 6))), 0, 8) . '.' . $unique_image;


    if (!isset($name)  || $name == "") {
      $msg = "<span class='error'>Alanlar Boş Olmamalı!</span> ";
      return $msg;
    } else {
      try {

        if (!empty($file_name)) {

          if ($file_size > 1054589) {
            echo "<span class='error'>Image Boyutu 1MB den fazla olmamalı!</span>";
          } elseif (in_array($file_ext, $permited) === false) {
            echo "<span class='error'> Sadece şu uzantılı dosyaları yükleyebilirsiniz: " . implode(',', $permited) . "</span>";
          } else {


            $columnName = 'icon';
            $tName = 'category';
            $columnId = 'catId';
            $this->delImageId($id, $tName, $columnId, $columnName);
            move_uploaded_file($file_temp, $uploaded_image);

          $query = "UPDATE category
          SET
            name  = '$name',
            icon  = '$uploaded_image'
          WHERE catId = '$id' ";
            $updated_row = $this->db->update($query);
            if ($updated_row) {
              $msg = "<span class='success' style='color:forestgreen;'>Category Güncelleme Başarılı.</span> ";
              header("refresh:5; url=blogdata.php");
              return $msg;
            } else {
              $msg = "<span class='error' style='color:red;'>Category Güncellenme Başarısız!</span> ";
              return $msg;
            }
          }
        } else {
          $query = "UPDATE category
          SET
            name  = '$name'
          WHERE catId = '$id' ";

          $updated_row = $this->db->update($query);
          if ($updated_row) {
            $msg = "<span class='success' style='color:forestgreen;'>Category Güncellendi.</span> ";
            header("refresh:5; url=category.php");
            return $msg;
          } else {
            $msg = "<span class='error' style='color:red;'>Category Güncellenmedi!</span> ";
            return $msg; // return This Message 
          }
        }
      } catch (Exception $e) {
        die($e->getMessage());
      }
    }
  }

  public function deleteCat($id)
  {
    $query = "DELETE FROM category WHERE catId ='$id' ";
    $deldata = $this->db->delete($query);
    if ($deldata) {
      $msg = "<span class='success' style='color:forestgreen;'>Categori Silindi.</span> ";
      header("refresh:3; url=category.php");
      return $msg; // return this Message 
    } else {
      $msg = "<span class='error' style='color:red;'>Categori Silinmedi.</span> ";
      return $msg; // return this Message 
    }
  }

  public function catBySearch($search)
  {
    $query = "SELECT * FROM category WHERE name LIKE '%$search%' order by catId";
    $result = $this->db->select($query);
    return $result;
  }
}
?>