<?php
    $servername = "localhost:3306";
    $username = "root";
    $password = "";
    $dbname = "lhopital";

    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $telephone=$_POST['telephone'];
    $courriel=$_POST['courriel'];
    $date=strtotime($_POST['date']);
    $date=date("Y-m-d",$date);
    $time=$_POST['time'];
    $tarif=$_POST['tarif'];

    $conn = mysqli_connect($servername,$username,$password,$dbname);
    if(mysqli_connect_error()){
        die('Connect error(' . mysqli_connect_error(). ')'. mysqli_connect_error());
    }else{
        $SELECT = "SELECT courriel FROM appointment WHERE courriel = ? LIMIT 1";
        $INSERT = "INSERT INTO appointment(`nom`,`prenom`,`telephone`,`courriel`,`date`,`time`,`tarif`)VALUES(?,?,?,?,?,?,?)";
        
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s",$courriel);
        $stmt->execute();
        $stmt->bind_result($courriel);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum==0){
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssssssi",$nom,$prenom,$courriel,$telephone,$date,$time,$tarif);
            $stmt->execute();
            echo "New record inserted succesfully";
        }else{
            echo "Someone has entered already this email!";

        }
        $stmt->close();
        $conn->close();

    }
