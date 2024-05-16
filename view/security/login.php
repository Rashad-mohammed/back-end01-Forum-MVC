<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Document</title>
</head>
<body>
<div class="login-container">
    <h2>Connexion</h2>

    <!-- Formulaire de connexion --> 
    <form method="post" action="../../index.php?ctrl=security&action=processLogin">
        <!-- //Cela suppose que notre formulaire de connexion se trouve dans un fichier de vue
        et qu'une fois soumis, il enverra une requête POST à ​​l'action processLogin du SecurityController via le fichier  index.php-->
        <label for="email">Email : </label><br>
        <input type="email" name="email" placeholder="Email"><br><br>

        <label for="password">password : </label><br>
        <input type="password" name="password" placeholder="password"><br><br>

        <button type="submit">Se connecter</button>
        <p>Vous n’avez pas de compte ?<a href="register.php">S’enregistrer</a></p>
    </form>

</div>
</body>
</html>

<style>
    .login-container{
    text-align: center;
    align-items: center;
}
.login-container form{
    width: 500px;
    padding:30px;
    border-radius: 15px;
    text-align: center;
    background: radial-gradient(rgb(139, 195, 245), #1294b8);
    position: relative;
    left: 32%;
}
.login-container label{}
.login-container input{
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
}
.login-container button{
    width: 50%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    background: #1294b8;
    color: white;
    cursor: pointer;
}
</style>