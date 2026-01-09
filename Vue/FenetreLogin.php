<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="login-page">
    <!-- Left side: background image + welcome text -->
    <div class="left-side">
        <div class="welcome-text">
            <h1>Bienvenue !</h1>
            <p>Connectez-vous pour continuer</p>
        </div>
    </div>

    <!-- Right side: login form + logo -->
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

<?php if (!empty($erreur)) : ?>
    <p><?php echo $erreur ?></p>
<?php endif; ?>
<?php
    echo password_hash('1234',PASSWORD_DEFAULT);
?>
</body>
</html>
