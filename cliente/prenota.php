<?php
    session_start();
    if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente']) || $_SESSION['tipo_utente'] != "cliente") {
        header("Location: ../logindenied.php");
    }

    require_once "../db.php";

    $idUtente = $_SESSION['id_utente'];
    $idArticolo = $_GET['id'];
    $checkSql = "SELECT stato FROM articoli WHERE id_articolo = $idArticolo";
    $checkResult = $conn->query($checkSql);
    $checkRow = $checkResult->fetch_assoc();
    if($checkRow['stato'] != "disponibile") {
        header("Location: ../articoloNonDisponibile.php");
    }
?>

<html>
<head>
    <title>Seleziona una data</title>
    <link rel="stylesheet" href="../style/styles.css" type="text/css">
    <link rel="stylesheet" href="../style/prenotaStyle.css" type="text/css">
</head>
<body>
    <input type="button" name="login" value="Indietro" onclick="location.href='cliente.php'">
    <div class="date-selection">
        <h1>Seleziona la data</h1>
        <form method="POST" action="salvaPrenotazione.php">
            <input type="date" name="selected_date">
            <input type="hidden" name="id_articolo" <?php echo "value=" . $idArticolo ?>>
            <input type="submit" value="Invia">
        </form>
    </div>
</body>
</html>