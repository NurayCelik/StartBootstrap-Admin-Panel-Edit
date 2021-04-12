<?php
/**
 * Session Class
 */
class Session{
  
	public static function init(){
         session_start();
         ob_start();
       
  }   
 
  public static function set($key, $val){ // that is the set method
    $_SESSION[$key] =  $val;
	} 

 
	public static function get($key){ // that is the get method
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}else {
			return false;
		}
	}  

 public static function checkSession(){
     self::init();
     
     if (self::get("adminlogin") == false || self::get("logget") + 20 * 60 < time()) {
          // 10*60 =10dak
       self::destroy(); // I added this when is will false then its will be apply selt::destroy method
       header("Location:login.php"); // Here is define its will be transfer to admin login.php page
      }
   }
   public static function checkLogin(){
  self::init(); // Here i stat this session with init method
    if (self::get("adminlogin") == true ) {
      header("Location:index.php"); // I just put the transfer location as dashbord.php page
        }
    }
    public static function loginCont(){
    self::init();
      if (self::get("adminlogin") == true ) {
         header("Location:index.php"); // I just put the transfer location as dashbord.php page

        }
        else
        {
          header("Location:login.php");
        }
    }
 
   public static function destroy(){ // that is the destory method
    self::get('adminName')==false;
    header("Cache-Control: no-cache, no-store, must-revalidate, Pragma:no-cache, Expires:0");
    header("refresh:1;login.php");
    session_destroy();
    session_unset();
    ob_end_flush();
    exit();
   } 
}
 
?>