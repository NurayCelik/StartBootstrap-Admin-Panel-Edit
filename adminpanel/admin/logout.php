<?php
               if (isset($_GET['action']) && $_GET['action'] == "logout"){ // Here i get this logout id 
                 Session::destroy(); 
                 Session::set('adminUser')=="";
                 Session::set("adminlogin", false);
                 Session::set("adminId", "");
                 Session::set("yetki", "");
                 $params = session_get_cookie_params();
                 setcookie(session_name(), '', 0, $params['path'], 
                 $params['domain'], $params['secure'], isset($params['httponly']));
                 header("Location:login.php");
                 // Here i destroy this Session for login user.
             }
             else
             {
             }
              ?>