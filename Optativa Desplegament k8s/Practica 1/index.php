<html>
<head>
<title>Prova PHP MYSQL</title>
</head>

<body>

<h1>La vida embeces, embeces la vida</h1>

<?php
/*
A la següent línia caldrà canviar de forma convenient la IP del contenidor amb el servidor de mysql.
La contrasenya de root està posada com a 'pepito'.
 */

$link = mysqli_connect("172.17.0.2", "root", "pepito", "p1docker");

// Check connection
if($link === false){
    die("ERROR: No connecta, tu. " . mysqli_connect_error());
}


$sql = "SELECT * FROM productes";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table>";
            echo "<tr>";
                echo "<th>Codi</th>";
                echo "<th>Producte</th>";
                echo "<th>Preu</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['idp'] . "</td>";
                echo "<td>" . $row['nomarticle'] . "</td>";
                echo "<td>" . $row['preu'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No hi ha registres";
    }
} else{
    echo "ERROR: No puc executar $sql. " . mysqli_error($link);
}

mysqli_close($link);
?>

</body>
</html>