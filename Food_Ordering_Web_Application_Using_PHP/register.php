<?php 
$conn = new mysqli("localhost", "root", "", "foodapp");

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
echo "Start";
if($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_FILES["profileImg"])){

    $targetDir = "images/profileImg/";

    $username = $_POST["username"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
    $role = $_POST["role"];

    if(!file_exists($targetDir)){
        mkdir($targetDir, 0777, true);
    }

    $targetfile = $targetDir . basename($_FILES["profileImg"]["name"]);
    $userImage = "../" . $targetfile;

    move_uploaded_file($_FILES["profileImg"]["tmp_name"],$targetfile);
   
    $sql = "INSERT INTO users (user_name, name, email, password, role,image) VALUES ('$username', '$name' ,'$email','$password','$role','$userImage')";

    if($conn->query($sql) === TRUE){
        echo "<script>alert('Register Successfully');</script>";
        header('location:login.html');
    }else{
        echo "Error : " . $conn->error;
    }
    $conn->close();

}
echo "End";


?>