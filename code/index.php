<!DOCTYPE html>
<html>
<body>

<?php

echo nl2br("Container Hostname:\r\n");
echo gethostname();
echo "<br></br>";
echo "database query results:";
echo "<br></br>";
$servername = "mysql";
$username = "root";
$password = "pass";
$dbname = "company";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Failed to connect to MySQL: " . $conn->connect_error);
}

$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

echo "<table border='1'>
<tr>
<th>Department</th>
<th>FirstName</th>
<th>LastName</th>
<th>EmailAddress</th>
</tr>";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['department'] . "</td>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";
    }
        echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>

</body>
</html>
