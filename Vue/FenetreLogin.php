<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="login-page">

    <div class="left-side">
        <div class="welcome-text">
            <h1>Bienvenue !</h1>
            <p>Connectez-vous pour continuer</p>
        </div>
    </div>

    <!-- Formulaire pour se connecter -->
    <div class="right-side">
        <div class="login-container">
            <img id="logo" src="Image/logoEquipe.jpg" alt="Logo Equipe">
            <form action="index.php" method="POST" class="login-form">
                <h2>Login</h2>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="mdp" placeholder="Mot de passe" required>
                <input type="submit" value="Se connecter">
            </form>
        </div>
    </div>

</div>

<!-- Affichage d'erreur -->
<?php if (!empty($erreur)) : ?>
    <p><?php echo $erreur ?></p>
<?php endif; ?>

</body>
</html>
