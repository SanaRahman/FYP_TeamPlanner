<?php
//include(".././database_connection.php");

Class manager{

    function manager_login($username,$password,$conn){
        $sql="SELECT * FROM accounts_manager WHERE username=?;";
        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
           header("Location: login.php?error=sqlerrorline24");
           exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            if($row=mysqli_fetch_assoc($result)){

             $pwdcheck=password_verify($password,$row['passwod']);
             if($pwdcheck==false ){
                 //$passwordErr="Wrong Password";
                 return 0;
             }
             else if($pwdcheck==true){
              session_start();
              $_SESSION['userid']=$row['userid'];
              $_SESSION['username']=$row['username'];
              $_SESSION['login_user']="manager";

              return 5;
            // header("Location:index.php?page=dashboard");
             }
             else{
               echo '<script>alert("Unexpected error occured")</script>';
             }
             }
             else{
              //   $nameErr="Username doesn't exists";
                return 1;
             }
            }
    }

    function insert_new_manager($username,$password,$gmail,$conn){

        $sql1="SELECT userid FROM accounts_manager WHERE username=?";
        $sql2="SELECT userid FROM accounts_manager WHERE gmail=?";
        $stmt=mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql1)){
        header("Location:signup.php?error=sql_error_line_26");
        exit();
        }
        else{
         mysqli_stmt_bind_param($stmt,"s",$username);
         mysqli_stmt_execute($stmt);
         mysqli_stmt_store_result($stmt);
         $result_check=mysqli_stmt_num_rows($stmt);
         if($result_check>0){
          // echo '<script>alert("This username is already taken")</script>';
          $nameErr="UserName already taken";
          return 1;
          }
         else{
             if (!mysqli_stmt_prepare($stmt,$sql2)){
               header("Location:signup.php?error=sqlerror line 38");
               exit();
               }
               else{
                 mysqli_stmt_bind_param($stmt,"s",$gmail);
                 mysqli_stmt_execute($stmt);
                 mysqli_stmt_store_result($stmt);
                 $result_check2=mysqli_stmt_num_rows($stmt);
                 if($result_check2>0){
                   return 2;
                   //echo '<script>alert("This Gmail is already registered")</script>';
                  }

                   else{
                       $sql4="INSERT INTO accounts_manager(username,passwod,gmail) VALUES(?,?,?)";
                       $stmt=mysqli_stmt_init($conn);
                       if(!mysqli_stmt_prepare($stmt,$sql4)){
                        header("Location: signup.php?error=sqlerrorline56");
                       }
                       else{

                        $hashpsd=password_hash($password, PASSWORD_DEFAULT);
                         mysqli_stmt_bind_param($stmt,"sss",$username,$hashpsd,$gmail);
                         mysqli_stmt_execute($stmt);
                         $last_id=mysqli_insert_id($conn);
                         $this->generate_account($last_id,$conn);
                         $this->manager_login($username,$password,$conn);

                       }
                   }

               }
           }
        }
    }


function generate_account($last_id,$conn){
  $dp="default_profile.jpg";
  $sql="INSERT INTO accounts(userid,dp)
  VALUES($last_id,'$dp')";
  $run=mysqli_query($conn,$sql);
  if(!$run){echo "eeeeeeeeeeeeeeeeeeeeee";}
}

}
