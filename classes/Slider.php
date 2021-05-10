<?php
$filepath = realpath(dirname(__FILE__)); //http://localhost/shop olan url kısım. daha kolay ulaşılsın diye yazıldı. Yoksa admin kısım rahat classlara ulaşırken diğer bölümler erişemiyor.
include_once($filepath . '/../datalib/Database.php');
include_once($filepath . '/../helpers/Format.php');

?>
 
<?php
class Slider
{
  private $db;  // I crate Property for Database Class
  private $fm; // I crate Property for Format Class  

  public function __construct()
  {
    $this->db   = new Database(); // I crate Object for Database Class
    $this->fm   = new Format(); // I crate Object for Format Class  
  }


 
  public function getAllSlider()
  {
    $query = "SELECT * FROM slider ORDER BY sliderId DESC ";
    $result =  $this->db->select($query);
    return $result;
  }

  public function getSliderById($id)
  {
    $query = "SELECT * FROM slider WHERE sliderId = '$id' ";
    $result =  $this->db->select($query);
    return $result;
  }
  public function deleteSlider($id)
  {
    $this->delImageId($id, 'slider', 'sliderId', 'image'); //Önce fotoyu silelim dosya yolunu kaybetmemek için
    $query = "DELETE FROM slider WHERE sliderId ='$id' ";
    $deldata = $this->db->delete($query);
    if ($deldata) {
      $msg = "<span class='success' style='color:forestgreen;'>Slider Data Silindi.</span> ";
      return $msg;
    } else {
      $msg = "<span class='error' style='color:red;'>Slider Data Silinmedi.</span> ";
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



  public function updateSlider($data, $files, $id)
  {
    $title     =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['title'])));
    $message   =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['message'])));

    $permited = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');

    $file_name  =  $files['image']['name'];
    $file_size  =  $files['image']['size'];
    $file_temp  =  $files['image']['tmp_name'];
    $file_type  =  $files['image']['type'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
    $uploaded_image = "../../uploads/slider/" . substr(md5(uniqid(rand(1, 6))), 0, 8) . '.' . $unique_image;


    if (!isset($title)  || $title == "" || !isset($message)  || $message == "") {
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


            $columnName = 'image';
            $tName = 'slider';
            $columnId = 'sliderId';
            $this->delImageId($id, $tName, $columnId, $columnName);
            move_uploaded_file($file_temp, $uploaded_image);

            $query = "UPDATE slider
            SET
              title          = '$title',
              message        = '$message',
              image          = '$uploaded_image'
            WHERE  sliderId  = '$id' ";
            $updated_row = $this->db->update($query);
            if ($updated_row) {
              $msg = "<span class='success' style='color:forestgreen;'>Slider Data Güncellendi.</span> ";
              header("refresh:5; url=slider.php");
              return $msg;
            } else {
              $msg = "<span class='error' style='color:red;'>Slider Data Güncellenmedi!</span> ";
              return $msg;
            }
          }
        } else {
          $query = "UPDATE slider
        SET
        title            = '$title',
        message          = '$message'
        WHERE   sliderId = '$id' ";
          $updated_row = $this->db->update($query);
          if ($updated_row) {
            $msg = "<span class='success' style='color:forestgreen;'>Slider Data Güncellendi.</span> ";
            header("refresh:5; url=slider.php");
            return $msg;
          } else {
            $msg = "<span class='error' style='color:red;'>Slider Data Güncellenmedi!</span> ";
            return $msg;
          }
        }
      } catch (Exception $e) {
        die($e->getMessage());
      }
    }
  }



  public function insertSlider($data, $files)
  {

    date_default_timezone_set('Europe/Istanbul');

    $title     =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['title'])));
    $message   =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['message'])));

    $permited = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');

    $file_name  =  $files['image']['name'];
    $file_size  =  $files['image']['size'];
    $file_temp  =  $files['image']['tmp_name'];
    $file_type  =  $files['image']['type'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
    $inserted_image = "../../uploads/slider/". $unique_image;

    if (!isset($title)  || $title == "" || !isset($message)  || $message == "") {
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

            $query = "INSERT INTO 
          slider(title, message, image) 
          VALUES ('$title', '$message','$inserted_image')";

            $inserted_row = $this->db->insert($query);
            if ($inserted_row) {
              header("refresh:3; url=slider.php");
              $msg = "<span class='success' style='color:forestgreen;'>Slider Data Eklendi.</span> ";
              return $msg; // return message 
            } else {
              $msg = "<span class='error' style='color:red;'>Slider Data Eklenmedi!</span> ";
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
