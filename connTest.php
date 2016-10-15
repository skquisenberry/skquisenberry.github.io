<?php
$servername = "webdb.uvm.edu";
$username = "omarshal_admin";
$password = "r2SK86J9SP6t";
$dbname = "OMARSHAL_hackvt";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully<br>";

function filter_libraries($conn) {
	$sql = "SELECT * FROM `Libraries` WHERE 1";
	$result = $conn -> query($sql);
	return $result;
}
function filter_makerspaces($conn) {
	$sql = "SELECT * FROM `Makerspaces` WHERE 1";
	$result = $conn -> query($sql);
	return $result;
}
function filter_infant($conn, $include_full) {
	if($include_full) {
		$sql = "SELECT * FROM `Childcare` WHERE `Reported Desired Infant Capacity` > 0";
	} else {
		$sql = "SELECT * FROM `Childcare` WHERE `Reported Infant Vacancies` > 0";
	}
	$result = $conn -> query($sql);
	return $result;
}
function filter_toddler($conn, $include_full) {
	if($include_full) {
		$sql = "SELECT * FROM `Childcare` WHERE `Reported Desired Toddler Capacity` > 0";
	} else {
		$sql = "SELECT * FROM `Childcare` WHERE `Reported Toddler Vacancies` > 0";
	}
	$result = $conn -> query($sql);
	return $result;
}
function filter_preschool($conn, $include_full) {
	if($include_full) {
		$sql = "SELECT * FROM `Childcare` WHERE `Reported Desired Preschool Capacity` > 0";
	} else {
		$sql = "SELECT * FROM `Childcare` WHERE `Reported Preschool Vacancies` > 0";
	}
	$result = $conn -> query($sql);
	return $result;
}
function filter_school_age($conn, $include_full) {
	if($include_full) {
		$sql = "SELECT * FROM `Childcare` WHERE `Reported Desired School Age Capacity` > 0";
	} else {
		$sql = "SELECT * FROM `Childcare` WHERE `Reported School Age Vacancies` > 0";
	}
	$result = $conn -> query($sql);
	return $result;
}
function print_childcare_rows($result) {
	if ($result->num_rows > 0) {
    	// output data of each row
    	while($row = $result->fetch_assoc()) {
        	echo $row["Provider Name"] . ", " . $row["Address 1"] . "<br>";
    	}
	} else {
    	echo "0 results";
	}
}
function print_library_rows($result) {
	if ($result->num_rows > 0) {
    	// output data of each row
    	while($row = $result->fetch_assoc()) {
        	echo $row["Library"] . ", " . $row["Street Address"] . "<br>";
    	}
	} else {
    	echo "0 results";
	}
}
function print_makerspace_rows($result) {
	if ($result->num_rows > 0) {
    	// output data of each row
    	while($row = $result->fetch_assoc()) {
        	echo $row["Name"] . ", " . $row["Address"] . "<br>";
    	}
	} else {
    	echo "0 results";
	}
}

print_makerspace_rows(filter_makerspaces($conn));

$conn->close();
?>