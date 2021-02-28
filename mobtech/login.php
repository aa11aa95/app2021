 <?php
include "connect.php";
if ($_SERVER['REQUEST_METHOD'] == "POST"){

  $email    = filter_var( $_POST['email'] , FILTER_SANITIZE_EMAIL) ;
  $password =  $_POST['password'] ;
  $token = $_POST['token'] ;

  $stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND password = ?") ;
  $stmt->execute(array($email , $password));

  $user = $stmt->fetch() ;

   $row = $stmt->rowcount()  ;

   if ($row > 0) {

       $id        = $user['id'] ;
       $stmt2 = $con->prepare("UPDATE users SET token = ? WHERE id = ? ") ;
       $stmt2->execute(array($token , $id )) ;


       $username  = $user['username'] ;
       $email     = $user['email'] ;
       $password  = $user['password'] ;
       echo json_encode(array('id' => $id , 'username' => $username ,'email' => $email ,'password' => $password , 'status' => "success"));
   }else {
     echo json_encode (array('status' => "faild" , 'email' => $email  , 'password' => $password) );
 }


}
?>
