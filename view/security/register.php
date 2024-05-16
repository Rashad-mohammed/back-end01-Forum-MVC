<!-- Formulaire d'inscription -->
<div class="login-container">
    <form method="post" action="../../index.php?ctrl=security&action=processRegister">

        <label for="pseudo">Pseudo : </label><br>
        <input type="text" name="pseudo" placeholder="Pseudo" required><br><br>

        <label for="email">Email : </label><br>
        <input type="email" name="email" placeholder="Email" required><br><br>

        <label for="confirmEmail">Confirmer Email : </label><br>
        <input type="email" name="confirmEmail" placeholder="Confirmer Email" required><br><br>

        <label for="password">Mot de passe : </label><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br><br>

        <label for="confirmPassword">Confirmer Mot de passe : </label><br>
        <input type="password" name="confirmPassword" placeholder="Confirmer Mot de passe" required><br><br>

        <button type="submit">S'inscrire</button>
        <p>Vous avez déjà un compte ? <a href="login.php">Se connecter</a></p>
    </form>
</div>
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