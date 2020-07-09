<?php
// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}
$failure=false;
if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
    if(strlen($_POST['make'])<1){
        $failure="Make is required";
    }
    elseif(is_numeric($_POST['year'])!=1 || is_numeric($_POST['mileage'])!=1){
        $failure="Mileage and year must be numeric";
    }
    else{
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $pdo->prepare('INSERT INTO autos(make, year, mileage) VALUES ( :mk, :yr, :mi)');
$stmt->execute(array(
':mk' => $_POST['make'],
':yr' => $_POST['year'],
':mi' => $_POST['mileage'])
);
print(htmlentities($_POST['make']));
print(htmlentities($_POST['year']));
print(htmlentities($_POST['mileage']));
echo('<p style="color:green;">Record inserted</p>');
}
}
?>
<!DOCTYPE html>
<head>
<title> pranavi auto</title>
<?php require_once "bootstrap.php";
require "pdo.php";
?>
</head>
<body>
<h1>
Welcome to autodatabase
<?php echo htmlentities($_REQUEST['name']);
?>
</h1>
<?php

if ( $failure !== false ) {

    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
   
?>
<form method="POST">
<label for="Make">Make</label>
<input type="text" name="make" id="make"><br/>
<label for="Year">Year</label>
<input type="text" name="year" id="year"><br/>
<label for="Mileage">Mileage</label>
<input type="text" name="mileage" id="milage"><br/>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>
</body>
</html>

