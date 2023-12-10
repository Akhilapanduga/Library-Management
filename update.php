<?php 
$input_data = file_get_contents("php://input");
parse_str($input_data, $_PUT);
$Id = isset($_PUT['ID']) ? $_PUT['ID'] : '';
$name = isset($_PUT['name']) ? $_PUT['name'] : '';
$author = isset($_PUT['author']) ? $_PUT['author'] : '';


$host="localhost";
$user="root";
$pass="";
$db="library";
$con=new mysqli($host,$user,$pass,$db);


if(!$con){
    echo "There is problem";
}
else{
    if (empty($Id) || empty($name) || empty($author)) {
        echo "Please provide all required fields."; //if all fields are not filled then ouput to provide required fields
    }
    else{
        $qry1 = "SELECT Book, Author FROM `info` where id=?"; //query to get the table contaning  where id=ID
        $stmt = $con->prepare($qry1);
        $stmt->bind_param("i", $Id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['Book'] == $name && $row['Author'] == $author) {
                    echo "Data Already existed";      //if data already present in the table it shows that already existed
                } else {
                    $qry = "UPDATE `info` SET Book = ?, Author= ? WHERE  id= ?"; // query to update the table
                    $stmt = $con->prepare($qry);
                    $stmt->bind_param("ssi", $name, $author, $Id);
                    $stmt->execute();

                    if (!$stmt) {
                        echo "There is a problem " . $con->error;
                    } else {
                        echo "Data Updated"; //After updating shows data updated
                    }
                }
            } 
            else {
                echo "No data found for the given ID"; //If user trying to update the book which doesnt exist then it shows no data found
            }
        } 
        else {
            echo "Problem with query";
        }
    }
    $con->close();
}


?>