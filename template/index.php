<?php
  session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet" type="text/css">
    <script src="assets/js/main.js"></script>
    <title>Projet Final SQL</title>
</head>
<body>
    <form method="post">
      <div class="container-login">
          <h1 class="txt-bvn">Bienvenue sur Projet Final SQL</h1>
          <div class="form-login">
              <label for="login">Login</label>
              <input type="text" name="login" id="login">
              <label for="password">Mot de passe</label>
              <input type="password" name="password" id="password">
              <button type="submit" oneclick="redirection()">Se connecter</button>
          </div>
      </div>
    </form>
    <?php
      $login=$_POST["login"];
      $password=$_POST["password"];
      if(isset($login)&&isset($password)){
        $link=mysqli_connect("localhost",$login,$password,"projetfinalsql");
        if (!$link){
            echo "
            <center>
              <section  id='main'>
                <p> Erreur : Impossible de se connecter à MySQL. </p>
                <p>Erreur de débogage : " . mysqli_connect_error() . "<P>
            </section>
            </center>";
        }
        else{
            echo "Connexion réussie...";
            sleep(1);
            header("Location: home.php");
            exit;

        }
      }

    ?>
</body>
