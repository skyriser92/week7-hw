<!DOCTYPE html>
<html>
<body>

<?php
echo "<table style='border: solid 1px black;'>";
 echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 

$servername = "sql2.njit.edu";
$username = "jcm44";
$password = "lq40ntX5";
$dbname = "jcm44";
$counter = 0;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	echo "Connected Successfully! <br>";
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, fname, lname FROM accounts WHERE id < 6"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
		$counter += 1;
    }
	if ($counter != 0){
	$counter = $counter/3;
	echo "<br>Number of records: $counter <br>";		
	}

}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?> 

</body>
</html>