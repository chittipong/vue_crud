<?php
$conn=new mysqli("localhost","root","","vue_crud");
if($conn->connect_error){
    die("Could not connect to database!");
}

$res =array('error'=>false);
$action='read';

if(isset($_GET['action'])){
    $action=$_GET['action'];
}

//============READ=================
if($action=='read'){
    $result=$conn->query("SELECT * FROM `users`");
    $users=array();
    
    while($row=$result->fetch_assoc()){
        array_push($users,$row);
    }

    $res['users']=$users;
}

//============CREATE=================
if($action=='create'){
    $uname=$_POST['username'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];

    $result=$conn->query("INSERT INTO `users` (`username`,`email`,`mobile`) 
    VALUES('$uname','$email','$mobile')");

    if($result){
        $res['message']="User added successfully";
    }else{
        $res['error']=true;
        $res['message']="Could not insert user";
    }
}


//============UPDATE=================
if($action=='update'){
    $id=$_POST['id'];
    $uname=$_POST['username'];    
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];

    $result=$conn->query("UPDATE `users` SET `username`='$uname',`email`='$email',`mobile`='$mobile' WHERE `id`='$id'");

    if($result){
        $res['message']="User updated successfully";
    }else{
        $res['error']=true;
        $res['message']="Could not update user";
    }
}

//============DELETE=================
if($action=='delete'){
    $id=$_POST['id'];

    $result=$conn->query("DELETE FROM `users` WHERE `id`='$id'");

    if($result){
        $res['message']="User deleted successfully";
    }else{
        $res['error']=true;
        $res['message']="Could not deleted user";
    }
}

$conn->close();

header("Content-type:application/json");
echo json_encode($res);
die();

?>