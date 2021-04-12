<?php 

$filepath= realpath(dirname(__FILE__));//http://localhost/shop olan url kısım. daha kolay ulaşılsın diye yazıldı. Yoksa admin kısım rahat classlara ulaşırken diğer bölümler erişemiyor.
include_once($filepath.'/../datalib/Database.php');
include_once($filepath.'/../helpers/Format.php');
 ?>

<?php
 class Category{
	private $db; // Create one Property for Database Class
	private $fm;// Create one Property for Format Class
 
    public function __construct(){
       $this->db   = new Database(); // Create one Object for Database Class
       $this->fm   = new Format(); // Create one Property for Object Class
	}
	public function catInsert($data){                
      $catName        =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['catName'] )));
      
      if (!isset($catName) || $catName == "") {
      $msg = "<span class='error'>Alanlar Boş Olmamalı.</span> ";
          return $msg;
     }else {
    
     try{
	    
      $query = "INSERT INTO category(catName) 
        VALUES ('$catName')";

        $inserted_row = $this->db->insert($query);
        if ($inserted_row) {
        $msg = "<span class='success' style='color:forestgreen;'>Categori eklendi.</span> ";
        header("refresh:3; url=category.php");
        return $msg; // return message 
      }else {
        $msg = "<span class='error' style='color:red;'>Categori eklenmedi.</span> ";
        return $msg; // return message 
      } 
 
        }
    
   catch(Exception $e)    
    {
      die($e->getMessage());
   		 }
	  }  
        }

   
    public function getAllCat(){
         $query = "SELECT * FROM category ORDER BY catId DESC";
         $result = $this->db->select($query);
         return $result;
     }
    public function getCatById($id){
         $query = "SELECT * FROM category WHERE catId ='$id' ";
         $result = $this->db->select($query);
         return $result;
     }

    public function catUpdate($data, $id){
      $catName        =  mysqli_real_escape_string($this->db->link, strip_tags(addslashes($data['catName'] )));
      
      if (!isset($catName) || $catName == "" ) {
      $msg = "<span class='error'>Alanlar Boş Olmamalı.</span> ";
          return $msg;
     }
     else {
    
     try{
	    
        $query = "UPDATE category
        SET
        catName     = '$catName',
        WHERE catId = '$id' ";
        
        $update_row  = $this->db->update($query);
        if ($update_row) {
          $msg = "<span class='success' style='color:forestgreen;'>Categori Güncellendi.</span> ";
            //header("refresh:3; url=category.php");
            return $msg; //Return the Message 
        }else {
          $msg = "<span class='error' style='color:red;'>Categori güncellenmedi.</span> ";
            return $msg; // Return the Message 
        }
      }
      catch(Exception $e){

        die($e->getMessage());

        }
	}  
 
 }

  public function deleteCat($id){
    $query = "DELETE FROM category WHERE catId ='$id' ";
    $deldata = $this->db->delete($query);
    if ($deldata) {
      $msg = "<span class='success' style='color:forestgreen;'>Categori Silindi.</span> ";
      header("refresh:3; url=category.php");
    return $msg; // return this Message 
    }else {
      $msg = "<span class='error' style='color:red;'>Categori Silinmedi.</span> ";
            return $msg; // return this Message 
      }
  }

    public function catBySearch($search){
    $query = "SELECT * FROM category WHERE catName LIKE '%$search%' order by catId";
     $result = $this->db->select($query);
     return $result;
  }
 
}
?>