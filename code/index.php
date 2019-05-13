<!DOCTYPE html>
<html>
<body>

<?php

echo gethostname();
echo nl2br("\r\n");
$servername = "mysql";
$username = "root";
$password = "pass";
$dbname = "company";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT first_name, last_name, department, email FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br>Department: ". $row["department"]. " -Name: ". $row["last_name"]. " " . $row["first_name"] . "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?> 

</body>
</html>
