<?php 
 require_once  __DIR__.'/../common/config.php';

     $hashedPassword=PASSWORD_HASH('4321', PASSWORD_DEFAULT);
       $data=$pdo->prepare("insert into users (name,email,phoneNumber,password,role)values(:name,:email,:phoneNumber,:password, :role)");
        $data->execute([
            ':name'=>'Admin',
            ':email'=>'bhartikapoor452@gmail.com',
            ':phoneNumber'=>'9816642824',
         ':password'=>$hashedPassword,
           ':role'=>'admin'
        ]);

?>