<?php 
    session_start();
    if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
        header("Location: logindenied.php");
    }

    $idUtente = $_SESSION['id_utente'];
    $idArticolo = $_POST['id_articolo'];
    $dataPrenotazione = $_POST['selected_date'];

    $servername = "localhost";
    $username = "root"; // Sostituisci con il tuo nome utente del database
    $password = ""; // Sostituisci con la tua password del database
    $dbname = "pauletta_enoteca2"; // Sostituisci con il nome del tuo database
    $conn = new mysqli($servername, $username, $password, $dbname);

    $insertSql = "INSERT INTO `prenotazioni` (`id_prenotazione`, `data_inizio`, `fk_id_utente`, `fk_id_articolo`) VALUES (NULL, '$dataPrenotazione', '$idUtente', '$idArticolo')";
    $conn->query($insertSql);

    $editSql = "UPDATE articoli SET stato = 'Prenotato' WHERE id_articolo = $idArticolo";
    $result = $conn->query($editSql);

    if($result)
    {
        header("Location: cliente.php");
    }
    else
    {
        echo "Errore nella prenotazione";
    }
?>