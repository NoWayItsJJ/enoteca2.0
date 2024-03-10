<?php
    //per vedere lo storico dei prestiti si possa fare l'unione delle due tabelle e joinare con la tabella prestiti

    require_once '../db.php';
    $id = $_GET['id'];
    $editSql = "UPDATE articoli SET stato='guasto' WHERE id_articolo = $id";
    $conn->query($editSql);
    $deleteSql = "DELETE FROM articoli WHERE id_articolo = $id";
    $conn->query($deleteSql);
    header('Location: visualizzaArticoli.php');
    exit;
?>