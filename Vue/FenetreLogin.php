<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>

<img id = "logo" src= "../Image/logoEquipe.jpg" alt="Logo Equipe">

<div class="login-container">
    <form action="../index.php" method="POST" class="login-form">
        <h2>Connexion</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="mdp" placeholder="Mot de passe" required>
        <input type="submit" value="Se connecter">
    </form>
</div>

<?php if (!empty($erreur)) : ?>
    <p><?php echo $erreur ?></p>
<?php endif; ?>
</body>
</html>
