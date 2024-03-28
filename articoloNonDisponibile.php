<!DOCTYPE html>
<html>
<head>
    <title>Articolo non disponibile</title>
    <!-- Includi Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Aggiungi regole CSS per centrare il contenuto */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: lightgrey;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 20px;
            max-width: 100%; /* Aggiunto per assicurare la larghezza massima */
        }

        .danger-icon {
            font-size: 5em; /* Dimensione grande per l'icona */
            color: red; /* Colore rosso per l'icona di pericolo */
            margin-bottom: 10px; /* Spazio tra l'icona e il testo */
        }

        .login-box {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 300px;
            width: 100%;
            margin-bottom: 20px; /* Aggiunge spazio tra il form e la tabella */
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #333333;
        }

        /* Stili per il pulsante di login */
        input[type="button"][name="login"] {
            margin-top: 20px;
            padding: 10px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background: #2196f3;
            color: #ffffff;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="button"][name="login"]:hover {
            background: #0d8bf2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <i class="fas fa-exclamation-triangle danger-icon"></i> <!-- Icona di pericolo -->
            <h2>Articolo non disponibile</h2>
            <input type="button" name="login" value="Pagina degli articoli" onclick="location.href='cliente/cliente.php'">
        </div>
    </div>
</body>
</html>
