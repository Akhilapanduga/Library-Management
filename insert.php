<?php 

$Id = isset($_POST['ID']) ? $_POST['ID'] : '';
$name = isset($_POST['name']) ? $_POST['name'] : '';
$author = isset($_POST['author']) ? $_POST['author'] : '';


$host="localhost";
$user="root";
$pass="";
$db="library";
$con=new mysqli($host,$user,$pass,$db);
if(!$con){
    echo "There is a problem";
}
else {
    if (empty($Id) || empty($name) || empty($author)) {
        echo "Please provide all required fields."; //if all fields are not filled then ouput to provide required fields
    }
    else{
        $qry1 = "SELECT * FROM `info` where id=?"; //query to get the table of id=$Id
        $stmt = $con->prepare($qry1);
        $stmt->bind_param("i", $Id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "Data Already existed"; //if we get rows with our present id then a data already exitsed in database, so it gives already existed
        } 
        else {
            $qry = "INSERT INTO `info`(`id`,`Book`,`Author`) VALUES (?, ?, ?)";//query to insert our data into database
            $stmt = $con->prepare($qry);
            $stmt->bind_param("iss", $Id, $name, $author);
            $stmt->execute();

            if (!$stmt) {
                echo "There is a problem " . $con->error;
            } 
            else {
                echo "Data inserted"; // afetr successfull insertion shows data inserted
            }
        }
}
$con->close();
}


?>