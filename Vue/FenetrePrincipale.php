<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fenêtre Principale</title>
    <style>
        /* Reset simple margins/padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            border-radius: 15px;
            padding: 40px 60px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            text-align: center;
            width: 500px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            background: #007bff;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn:hover {
            background: #0056b3;
        }

        .btn-secondary {
            background: #28a745;
        }

        .btn-secondary:hover {
            background: #1e7e34;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Fenêtre Principale</h1>
    <p>Bienvenue dans l'application de gestion de votre équipe !</p>

    <!-- Buttons to navigate between windows -->
    <a href="index.php?action=fen1" class="btn">Liste des Joueurs</a>
    <a href="index.php?action=fen2" class="btn btn-secondary">Liste des Matchs</a>
    <a href="index.php?action=fen3" class="btn">Statistiques</a>
</div>

</body>
</html>
