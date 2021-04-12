<?php 
$filepath= realpath(dirname(__FILE__));//http://localhost/shop olan url kısım. daha kolay ulaşılsın diye yazıldı. Yoksa admin kısım rahat classlara ulaşırken diğer bölümler erişemiyor.
include_once($filepath.'/../datalib/Database.php');
include_once($filepath.'/../helpers/Format.php');
 
?>
 
<?php
class User{
	private $db;  // I crate Property for Database Class
	private $fm; // I crate Property for Format Class  
 
  public function __construct(){
       $this->db   = new Database(); // I crate Object for Database Class
       $this->fm   = new Format(); // I crate Object for Format Class  
	}

  public function getAdminData(){
      $query = "SELECT * FROM admin where id > 1";
      $result = $this->db->select($query);
      return $result;

  }
  public function getAdminIdData(){
    $query = "SELECT * FROM admin where id = 1";
    $result = $this->db->select($query);
    return $result;

   }
   public function getAdminId($id){
    $query = "SELECT * FROM admin where id = '$id'";
    $result = $this->db->select($query);
    return $result;

   }
   public function deleteUser($id){

    $query = "DELETE FROM admin WHERE id = '$id' ";
    $deletedData = $this->db->delete($query);
    if ($deletedData) {
      $msg = "<span class='success' style='color:forestgreen;'>Delete Succesfully.</span> ";
      return $msg;
    }else {
      $msg = "<span class='error' style='color:red;'>Not Deleted</span> ";
      return $msg;
      } 
   }

    public function adminInsert($data){                
      $adminPas    =  $this->fm->validation($data['password']);
      $adminPass    =  mysqli_real_escape_string($this->db->link, stripslashes($adminPas));
      
      $confirmPas =   $this->fm->validation($data['confirmpassword']);
      $confirmPass    =  mysqli_real_escape_string($this->db->link, stripslashes($confirmPas));
      
      $adminUse    = $this->fm->validation($data['username']);
      $adminUser    =  mysqli_real_escape_string($this->db->link, stripslashes($adminUse ));
      

      $confirmPass1 = $this->fm->sifreKontrolEt($confirmPass);
      $confirmPass2 = $this->fm->sqlonleme($confirmPass);

      $adminPass1 = $this->fm->sifreKontrolEt($adminPass);
      $adminPass2 = $this->fm->sqlonleme($adminPass);


      $adminUser1 = $this->fm->adminNameKontrol($adminUser);
      $adminUser2 = $this->fm->sqlonleme($adminUser);


      
      $options = array('cost' => 11);
      $hashed_password =  password_hash($adminPass, PASSWORD_BCRYPT,$options);

      $usertype    = $this->fm->validation($data['usertype']);
      $usertypen   =  mysqli_real_escape_string($this->db->link, $usertype );
      $usertype1   =  $this->fm->textKontrolEt($this->fm->sqlonleme($usertypen));
      
      $adminEmailnn   = $this->fm->validation($data['useremail']);
      $adminEmailn  =  mysqli_real_escape_string($this->db->link, $adminEmailnn );
      $adminEmail  =  $this->fm->emailKontrolEt($adminEmailn);
      
      if ($adminUse == "" || $adminEmailnn == "" || $usertype == ""){
        $msg = "<span class='error'>Field Must Not be empty .</span> ";
            return $msg;
       }
       elseif ($adminPass2 != $confirmPass2) {
          $loginmsg ='Error! Password ve confirm password uyuşmuyor.';
          return $loginmsg;
          exit();
       }
        elseif($adminPass1 == false){
          $loginmsg ='Error! Lütfen şifrenizi ya sayı ya rakam  veya -, _, $ işaretlerinden seçerek belirleyiniz ';
          return $loginmsg;
          exit();
        }
        elseif($adminPass2 == false ){
          $loginmsg ='Error! Lütfen şu sözcükleri seçmeyiniz : <br>"content-type", "bcc:", "to:", "cc:", "href", "* from", "* FROM", "*from", "*FROM", "select", "SELECT", "SET", "set", "update", "UPDATE", "updateset", <br>"UPDATESET", "UPDATE SET", "DELETE", "delete", "*", "SELECT*FROM", "s3", "S3", "%7C", "%2B"';
          return $loginmsg;
          exit();
        }
        elseif($adminUser1 == false)
        {
          $loginmsg ='Error! Lütfen Kullanıcı adınızı ya rakam ya harf ya da - ve _ işaretlerinden seçerek oluşturunuz!';
          return $loginmsg;
          exit();
        }
        elseif ($adminUser2 == false){
          $loginmsg ='Error! Lütfen şu sözcükleri seçmeyiniz : <br>"content-type", "bcc:", "to:", "cc:", "href", "* from","* FROM", "*from", "*FROM", "select", "SELECT", "SET", "set", "update", "UPDATE", "updateset",<br> "UPDATESET", "UPDATE SET","DELETE", "delete", "*", "SELECT*FROM", "s3", "S3", "%7C", "%2B"';
          return $loginmsg;
          exit();
        }
       elseif(!$adminEmail)
        {
          $loginmsg = "Error!";
          return $loginmsg;
          exit();
        }
        elseif(!$usertype1)
        {
          $loginmsg = "Error!";
          return $loginmsg;
          exit();
        }
         else {
           
          try{
            $query = "INSERT INTO admin(username, useremail, password, usertype) 
              VALUES ('$adminUser','$adminEmail','$hashed_password','$usertypen')";  
     
              $inserted_row = $this->db->insert($query); 
              if ($inserted_row) {
            $msg = "<span class='success' style='color:forestgreen;'>Added To Compare.</span> ";
          return $msg;
          }else {
            $msg = "<span class='error' style='color:red;'>Not Added.</span> ";
               return $msg;
            } 
          
        }catch(Exception $e)    
        {
          die($e->getMessage());
            }
        }

  }
    public function adminUpdate($data, $id){
      $adminPas    =  $this->fm->validation($data['password']);
      $adminPass   =  mysqli_real_escape_string($this->db->link, stripslashes($adminPas));

      $adminUse    =  $this->fm->validation($data['username']);
      $adminUser   =  mysqli_real_escape_string($this->db->link, stripslashes($adminUse ));
      
      $adminPass1 = $this->fm->sifreKontrolEt($adminPass);
      $adminPass2 = $this->fm->sqlonleme($adminPass);


      $adminUser1 = $this->fm->adminNameKontrol($adminUser);
      $adminUser2 = $this->fm->sqlonleme($adminUser);

      $options = array('cost' => 11);
      $hashed_password =  password_hash($adminPass, PASSWORD_BCRYPT,$options);

      $usertype    = $this->fm->validation($data['usertype']);
      $usertypen   =  mysqli_real_escape_string($this->db->link, $usertype );
      $usertype1   =  $this->fm->textKontrolEt($this->fm->sqlonleme($usertypen));
      
      $adminEmailnn   = $this->fm->validation($data['useremail']);
      $adminEmailn  =  mysqli_real_escape_string($this->db->link, $adminEmailnn );
      $adminEmail  =  $this->fm->emailKontrolEt($adminEmailn);
     
      if ($adminUse == "" || $adminEmailnn == "" || $usertype == ""){
        $msg = "<span class='error'>Field Must Not be empty .</span> ";
            return $msg;
       }
       
       elseif($adminPass1 == false){
          $loginmsg ='Error! Lütfen şifrenizi ya sayı ya rakam  veya -, _, $ işaretlerinden seçerek belirleyiniz ';
          return $loginmsg;
          exit();
        }
        elseif($adminPass2 == false ){
          $loginmsg ='Error! Lütfen şu sözcükleri seçmeyiniz : <br>"content-type", "bcc:", "to:", "cc:", "href", "* from", "* FROM", "*from", "*FROM", "select", "SELECT", "SET", "set", "update", "UPDATE", "updateset", <br>"UPDATESET", "UPDATE SET", "DELETE", "delete", "*", "SELECT*FROM", "s3", "S3", "%7C", "%2B"';
          return $loginmsg;
          exit();
        }
        elseif($adminUser1 == false)
        {
          $loginmsg ='Error! Lütfen Kullanıcı adınızı ya rakam ya harf ya da - ve _ işaretlerinden seçerek oluşturunuz!';
          return $loginmsg;
          exit();
        }
        elseif ($adminUser2 == false){
          $loginmsg ='Error! Lütfen şu sözcükleri seçmeyiniz : <br>"content-type", "bcc:", "to:", "cc:", "href", "* from","* FROM", "*from", "*FROM", "select", "SELECT", "SET", "set", "update", "UPDATE", "updateset",<br> "UPDATESET", "UPDATE SET","DELETE", "delete", "*", "SELECT*FROM", "s3", "S3", "%7C", "%2B"';
          return $loginmsg;
          exit();
        }
       elseif(!$adminEmail)
        {
          $loginmsg = "Error!";
          return $loginmsg;
          exit();
        }
        elseif(!$usertype1)
        {
          $loginmsg = "Error!";
          return $loginmsg;
          exit();
        }
         else {
          try{
          
          $query = "UPDATE admin
          SET 
          username        = '$adminUser',
          useremail       = '$adminEmailn',
          password        = '$hashed_password',
          usertype        = '$usertypen'
          WHERE id  =  '$id'";
      
          $updated_row = $this->db->update($query);
          if ($updated_row) {
         // header("refresh:2; url=index.php");
          $msg = "<span class='success' style='color:forestgreen;'>Admin Updated Successfully.</span> ";
          return $msg;
        }else {
          $msg = "<span class='error' style='color:red;'>Admin Not Updated .</span> ";
          return $msg;
        }
        
          
        }catch(Exception $e)    
        {
          die($e->getMessage());
            }
        }
 }

 

}
?>