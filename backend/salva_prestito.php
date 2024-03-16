<?php 
    session_start();
    if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
        header("Location: ../logindenied.php");
    }

    $idUtente = $_POST['loanUser'];
    $idArticolo = $_POST['id_articolo'];
    $loaned = $_POST['loaned'];
    $dataPrestito = $_POST['selected_date']; //trigger per controllare che la data sia futura, se non lo è metterla uguale alla data di inizio

    require_once "../db.php";

    switch($loaned)
    {
        case 0:
            $editSql = "UPDATE articoli SET stato = 'in prestito' WHERE id_articolo = $idArticolo";
            $conn->query($editSql);
            $loanSql = "INSERT INTO prestiti (id_prestito, data_inizio, fk_id_utente, fk_id_articolo) VALUES (NULL, '$dataPrestito', '$idUtente', '$idArticolo')";
            $result0 = $conn->query($loanSql);
            if($result0)
            {
                header("Location: visualizzaArticoli.php");
            }
            break;
        case 1:
            $editSql2 = "UPDATE articoli SET stato = 'disponibile' WHERE id_articolo = $idArticolo";
            $conn->query($editSql2);
            $restituzioneSql = "UPDATE prestiti SET data_fine = '$dataPrestito' WHERE fk_id_articolo = $idArticolo AND data_fine IS NULL";
            $result1 = $conn->query($restituzioneSql);
            if($result1)
            {
                header("Location: visualizzaArticoli.php");
            }
            break;
    }
?>