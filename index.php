<!DOCTYPE html>
<html>
<head>
    <title>Login area riservata</title>
    <link rel="stylesheet" href="style/styles.css" type="text/css">
</head>
<body>

<?php
// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Recupera i dati dal form
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    //Connessione al database
    require_once "db.php";

    if(filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $passmd5 = md5($pass);
        //Prepara e esegui la query per l'inserimento dei dati nella tabella
        $sql = "SELECT * FROM utenti WHERE email='$email' and password='$passmd5'";

        $result = $conn->query($sql);
        if($result->num_rows>0)
        {
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $passmd5;
            while($row = $result->fetch_assoc())
            {
                $_SESSION['id_utente'] = $row["id_utente"];
                $_SESSION['tipo_utente'] = $row["tipo_utente"];
                switch($row["tipo_utente"])
                {
                    case "cliente":
                        header("Location: ./cliente/visualizzaCliente.php");
                        break;
                    case "operatore":
                    case "admin":
                        header("Location: backend/sceltaAdmin.php");
                        break;
                }
            }
        }
        else {
            echo '<script>alert("Identificazione non riuscita: nome utente o password errati")</script>';
        }
    }
    else{
        echo '<script>alert("Dati inseriti non validi")</script>';
    }
}
?>
<input type="button" name="login" value="Registrati" onclick="location.href='registrazione_cliente.php'">
<div class="container">
    <div class="login-box">
        <h2>Inserisci le tue credenziali:</h2>

        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div class="user-box"><input type="email" name="email" required><label>Email</label></div>
        <div class="user-box"><input type="password" name="pass" required><label>Password</label></div>
        <input class="submit" type="submit" value="Accedi">
        </form>
    </div>
</div>
</body>
</html>