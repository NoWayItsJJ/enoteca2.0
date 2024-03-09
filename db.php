<?php
$servername = "localhost";
$username = "root"; // Sostituisci con il tuo nome utente del database
$password = ""; // Sostituisci con la tua password del database
$dbname = "pauletta_enoteca2"; // Sostituisci con il nome del tuo database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>