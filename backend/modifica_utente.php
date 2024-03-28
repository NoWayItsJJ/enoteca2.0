<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente']) || ($_SESSION['tipo_utente'] != "admin")) {
    header("Location: ../logindenied.php");
}

// Connessione al database
require_once '../db.php';

// Recupera l'ID dalla query string
if(isset($_GET["id"]))
{
    $id = $_GET['id'];
}

// Query SQL per selezionare il record corrispondente all'ID
$sql = "SELECT id_utente, nome, cognome, tipo_utente, indirizzo, email, password FROM utenti WHERE id_utente = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$tipo = $row['tipo_utente'];

// Chiudi la connessione al database
$conn->close();
?>

<html>
<head>
    <title>Modifica utente</title>
    <link rel="stylesheet" href="../style/styles.css" type="text/css">
</head>
<body>
    <input type="button" name="login" value="Indietro" onclick="location.href='visualizzaUtenti.php'">
    <div class="container">
        <div class="login-box">
            <h2>Modifica utente:</h2>
            
    <form method="post" action="salva_modifiche_utente.php">
        <div class="user-box"><input type="text" name="nome" <?php echo "value=".$row["nome"]?> placeholder="Nome" required><label>Nome</label></div>
        <div class="user-box"><input type="text" name="cognome" <?php echo "value=".$row["cognome"]?> placeholder="Cognome" required><label>Cognome</label></div>
        <div><select class="select" name="tipo_utente" required>
            <option value="cliente" <?php if($tipo==='cliente') echo 'selected="selected"';?>>Cliente</option>
            <option value="operatore" <?php if($tipo==='operatore') echo 'selected="selected"';?>>Operatore</option>
            <option value="admin" <?php if($tipo==='admin') echo 'selected="selected"';?>>Admin</option>
        </select>
        </div>
        <div class="user-box"><input type="text" name="indirizzo" <?php echo "value='".$row["indirizzo"]."'"?> placeholder="Indirizzo" required><label>Indirizzo</label></div>
        <div class="user-box"><input type="email" name="email" <?php echo "value=".$row["email"]?> placeholder="Email" required></div>
        <div class="user-box"><input type="text" name="password" <?php echo "value=".$row["password"]?> placeholder="Password" required></div>
        <div><input type="hidden" name="id" <?php echo "value=".$row["id_utente"]?>></div>
        <div><input type="hidden" name="old_email" <?php echo "value=".$row["email"]?>></div>
        <div><input type="hidden" name="old_psw" <?php echo "value=".$row["password"]?>></div>
        <input class="submit" type="submit" value="Salva modifiche">
    </form>
</html>