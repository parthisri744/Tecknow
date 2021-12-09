<?php
$action = $_GET['action'];
if($action=="insert"){
    insert_data();
}elseif($action="fetch"){
    fetch_data();
}

function insert_data(){
$conn = new PDO("mysql:host=localhost;dbname=parthisri", "root","");
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
if(isset($request)){

    foreach($request as $value){
        if(isset($value->ID)){
            $query = "UPDATE  users SET name=:name,email=:email,mobile=:mobile WHERE ID =:ID";
            $stmt = $conn->prepare($query);
            $stmt->bindParam("name", $value->name);
            $stmt->bindParam("email", $value->email);
            $stmt->bindParam("mobile", $value->mobile);
            $stmt->bindParam("ID", $value->ID);
            if($stmt->execute())
            {
             echo 'Data Updated';
            }else{
             echo 'Not Updated';
            }
        }else{
            $query = "INSERT INTO users (name,email,mobile) VALUES (:name,:email,:mobile)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam("name", $value->name);
            $stmt->bindParam("email", $value->email);
            $stmt->bindParam("mobile", $value->mobile);
            if($stmt->execute())
            {
             echo 'Data Inserted';
            }else{
             echo 'Not Inserted';
            }
          }
        }
     }
}
function fetch_data(){
    $conn = new PDO("mysql:host=localhost;dbname=parthisri", "root","");
    $query = "SELECT ID,name,email,mobile FROM users";
    $statement = $conn->prepare($query);
    if($statement->execute())
    {
     while($row = $statement->fetch(PDO::FETCH_ASSOC))
     {
      $data[] = $row;
     }
     echo json_encode($data);
    }
}
