<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['sfirstname']) && isset($_POST['slastname']) &&
        isset($_POST['sgender']) && isset($_POST['s12percentage']) &&
        isset($_POST['semail']) && isset($_POST['sPINCODE']) &&
        isset($_POST['snumber']) && isset($_POST['saddress']) &&
        isset($_POST['sadharnumber'])) {
        
        $sfirstname = $_POST['sfirtname'];
        $slastname = $_POST['slastname'];
        $sgender = $_POST['sgender'];
        $s12percentage = $_POST['s12percentage'];
        $semail = $_POST['semail'];
        $sPINCODE = $_POST['sPINCODE'];
        $snumber = $_POST['snumber'];
        $saddress = $_POST['saddress'];
        $sadharnumber = $_POST['sadharnumber'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "cuwebpage";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT semail FROM register WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(sfirstname,slastname, sgender,s12percentage,semail,sPINCODE,snumber,saddress,sadharnumber) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $semail);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sssisiisi",$sfirstname,$slastname,$sgender,$s12percentage,$semail,$sPINCODE,$snumber,$saddress,$sadharnumber);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>