<?php
    //per vedere lo storico dei prestiti si possa fare l'unione delle due tabelle e joinare con la tabella prestiti

    require_once '../db.php';
    $id = $_GET['id'];
    $editSql = "UPDATE articoli_dismessi SET stato='disponibile' WHERE id_articolo2 = $id";
    $conn->query($editSql);
    $deleteSql = "DELETE FROM articoli_dismessi WHERE id_articolo2 = $id";
    $conn->query($deleteSql);
    header('Location: visualizzaArticoli.php');
    exit;
?>