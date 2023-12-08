<?php
   include("class/User.php");
   include_once("class/Session.php");
   Session::init();
   if (isset($_GET['action']) && $_GET['action'] == "logout") {
         Session::destroy();
}

?>

