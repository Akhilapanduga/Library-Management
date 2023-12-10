<?php
$host="localhost";
$user="root";
$pass="";
$db="library";
$con=new mysqli($host,$user,$pass,$db);
if(!$con){
    echo "There is problem";
}

$qry="SELECT * FROM `info`"; //query to output the all the information contaning in the table
$result=$con->query($qry);
 
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $bookid=$row["id"];
        $bookname=$row["Book"];
        $bookauthor=$row["Author"];

        $book_data["bookName"]=$bookname;
        $book_data["bookauthor"]=$bookauthor;
        $book_data["bookid"]=$bookid;
        $data[$bookid]=$book_data;
    }
    $data["Result"]="True";
     $data["Message"]="Books fetched successfully";
}
else{
        $data["Result"]="False";
        $data["Message"]="No Books Found";
}
echo json_encode($data, JSON_UNESCAPED_SLASHES);
?>