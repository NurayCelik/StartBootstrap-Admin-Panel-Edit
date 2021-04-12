<?php 
$filepath= realpath(dirname(__FILE__));//http://localhost/shop olan url kısım. daha kolay ulaşılsın diye yazıldı. Yoksa admin kısım rahat classlara ulaşırken diğer bölümler erişemiyor.
include_once($filepath.'/../datalib/Database.php');
include_once($filepath.'/../helpers/Format.php');
 
?>
 
<?php
class Blog{
	private $db;  // I crate Property for Database Class
	private $fm; // I crate Property for Format Class  
 
    public function __construct(){
       $this->db   = new Database(); // I crate Object for Database Class
       $this->fm   = new Format(); // I crate Object for Format Class  
	}


public function getAllB(){ 
        $query = "SELECT * FROM blogpost ORDER BY id DESC";
         $result = $this->db->select($query);
         return $result; 
       }
  public function getAllBlog(){
  $query = "SELECT blogpost.*, category.*
          FROM blogpost
          INNER JOIN category
          ON blogpost.catId = category.catId
          ORDER BY blogpost.id DESC ";
  $result =  $this->db->select($query);
  return $result; 
  }

  public function getIdBlogData($id){
    $query = "SELECT blogpost.*, category.*
            FROM blogpost
            INNER JOIN category
            ON blogpost.catId = category.catId 
            WHERE id = '$id' ";
    $result =  $this->db->select($query);
    return $result; 
    }
  public function deleteBlog($id){
    $this->delImageId($id,'blogpost','id','myImage'); //Önce fotoyu silelim dosya yolunu kaybetmemek için
    $query = "DELETE FROM blogpost WHERE id ='$id' ";
    $deldata = $this->db->delete($query);
    if ($deldata) {
    $msg = "<span class='success' style='color:forestgreen;'>Blog Data Silindi.</span> ";
       return $msg; 
    }else {
      $msg = "<span class='error' style='color:red;'>Blog Data Silinmedi.</span> ";
        return $msg; 
      }
  }
       
      public function delImageId($id,$tableName,$tableId,$column){
      $query = "SELECT * FROM $tableName WHERE $tableId ='$id' ";
       $getData = $this->db->select($query);
         if ($getData) {
           while ($delImg = $getData->fetch_assoc()) {
            
           $dellink = $delImg[$column];
            @unlink($dellink);
          }
            }
     }


 
  public function updateBlog($data, $files, $id)
     { 
   
      $title              =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['title'] )));
      $details            =  mysqli_real_escape_string($this->db->link, $this->fm->validation(strip_tags(addslashes($data['details'] ))));
      $date               =  mysqli_real_escape_string($this->db->link, $this->fm->validation(strip_tags(addslashes($data['blogDate'] ))));
      $catId              =  mysqli_real_escape_string($this->db->link, $data['catId']);
      $featuredImageUrl   =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['featuredImageUrl'] )));
      
      $permited = array('jpg','png','jpeg','gif','JPG','JPEG','PNG','GIF');
      
      $file_name  =  $files['myImage']['name'];
      $file_size  =  $files['myImage']['size'];
      $file_temp  =  $files['myImage']['tmp_name'];
      $file_type  =  $files['myImage']['type'];
   
       $div = explode('.', $file_name);
       $file_ext = strtolower(end($div));
       $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
       $uploaded_image= "../../uploads/".substr(md5(uniqid(rand(1,6))), 0, 8).'.'.$unique_image;
      
       
      if($title == "" || $details == ""|| $catId == "" || $date == "" ) {
      $msg = "<span class='error'>Alanlar Boş Olmamalı!</span> ";
          return $msg;
     }else {
      try{
    
     if (!empty($file_name)) {
        
        if ($file_size > 1054589 ) {
          echo "<span class='error'>Image Boyutu 1MB den fazla olmamalı!</span>";
         }elseif (in_array($file_ext, $permited) === false) {
          echo "<span class='error'> Sadece şu uzantılı dosyaları yükleyebilirsiniz: ".implode(',', $permited)."</span>";
          } else{
             
      
             $columnName='myImage';
             $tName='blogpost';
             $columnId='id';
             $this->delImageId($id,$tName,$columnId,$columnName);
             move_uploaded_file($file_temp, $uploaded_image);
           
         $query = "UPDATE blogpost
            SET
            title                 = '$title',
            details               = '$details',
            blogDate              = '$date',
            myImage               = '$uploaded_image',
            featuredImageUrl      = '$featuredImageUrl',
            catId                 = '$catId'
          WHERE id = '$id' ";
             $updated_row = $this->db->update($query);
          if ($updated_row) {
          $msg = "<span class='success' style='color:forestgreen;'>Medya Güncelleme Başarılı.</span> ";
          header("refresh:5; url=blogdata.php");
          return $msg;
        }else {
          $msg = "<span class='error' style='color:red;'>Medya Güncellenme Başarısız!</span> ";
          return $msg;
        } 
   }
 }
       else{
        $query = "UPDATE blogpost
        SET
        title                 = '$title',
        details               = '$details',
        blogDate              = '$date',
        featuredImageUrl      = '$featuredImageUrl',
        catId                 = '$catId'
        WHERE id = '$id' ";

          $updated_row = $this->db->update($query);
          if ($updated_row) {
           $msg = "<span class='success' style='color:forestgreen;'>Blog Güncelleme Başarılı.</span> ";
           header("refresh:5; url=blogdata.php");
           return $msg;
        }else {
          $msg = "<span class='error' style='color:red;'>Blog Güncellenme Başarısız!</span> ";
          return $msg; // return This Message 
        } 
 
        }
    }
 

   catch(Exception $e)    
    {
      die($e->getMessage());
       }
  }  
}


 
   public function InsertBlog($data, $files){
     
    date_default_timezone_set('Europe/Istanbul');

    $title              =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['title'] )));
    $details            =  mysqli_real_escape_string($this->db->link, $this->fm->validation(strip_tags(addslashes($data['details'] ))));
    $date               =  mysqli_real_escape_string($this->db->link, $this->fm->validation(strip_tags(addslashes($data['blogDate'] ))));
    $catId              =  mysqli_real_escape_string($this->db->link, $data['catId']);
    $featuredImageUrl   =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['featuredImageUrl'] )));

    $permited = array('jpg','png','jpeg','gif','JPG','JPEG','PNG','GIF');
    
    $file_name  =  $files['myImage']['name'];
    $file_size  =  $files['myImage']['size'];
    $file_temp  =  $files['myImage']['tmp_name'];
    $file_type  =  $files['myImage']['type'];
 
     $div = explode('.', $file_name);
     $file_ext = strtolower(end($div));
     $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
     $inserted_image = "../../uploads/".$unique_image; 
     if ($file_size > 1054589 ) {
          echo "<span class='error'>Image Boyutu 1MB den fazla olmamalı!</span>";
         }elseif (in_array($file_ext, $permited) === false) {
          echo "<span class='error'> Sadece şu uzantılı dosyaları yükleyebilirsiniz: ".implode(',', $permited)."</span>";
          } else{
             
          move_uploaded_file($file_temp, $inserted_image);
          
          $query = "INSERT INTO blogpost(title, details, blogDate, myImage, featuredImageUrl, catId) 
          VALUES ('$title', '$details','$date', '$inserted_image','$featuredImageUrl', '$catId')";  
 
          $inserted_row = $this->db->insert($query);
          if ($inserted_row) {
            header("refresh:3; url=blogdata.php");
          $msg = "<span class='success' style='color:forestgreen;'>Blog Data Eklendi.</span> ";
          return $msg; // return message 
        }else {
          $msg = "<span class='error' style='color:red;'>Blog Data Eklenmedi!</span> ";
          return $msg; // return message 
        } 
     }
    
    }
}
 