<?php
  session_start();
 ?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="assets/css/home.css" type="text/css">
    <title>Projet Final SQL</title>
    <style>
        #main2 {
          text-align: left;
        	width:40%;
        	border:1px dashed #444;
        	margin:1em;
        	padding:1em;
        	background:#fff;
        }

        #main3 {
          text-align: left;
        	width:40%;
        	border:1px dashed #444;
        	padding:1em;
        	background:#fff;
        }
        #main3.form {
          text-align: justify;
        }

        #main2 ,#main3 {
          display: inline-block;
          vertical-align: middle;


        }
        tr {
          border: 1px solid #562e00;
        }

        input:checked + label {
          color: red;
          font-weight: bold;
        }

        option:checked {
          box-shadow: 0 0 0 3px lime;
          color: red;
          font-weight: bold;
        }

        input:out-of-range {
          color: red;
          font-weight: bolder;
        }
    </style>
  </head>
  <body>
    <!-- Header -->
    <header>
        <h1>Home</h1>
    </header>

    <!-- section -->
    <center>
      <section id="main">
          <p style="font-family: Verdana; font-weight: bold">Bienvenue BddUser<br></p>
          

          <?php
            $hid="Location: accueil_Bdd.php";

            //
            $link = mysqli_connect("localhost", "mysqllocal", "localpasswd", "projetfinalsql");
            date_default_timezone_set('Europe/Paris');
            $date=date("d:m:o");
            $heure=date("H:i");
            echo 'Le '.$date.' à '.$heure.'<br/><br/>';
            $wait = 1;

            $result = mysqli_query($link, "show tables;");
            ?>
            <div >
              <p>Choix de la table:</p>
              <form method="post">
                <select name="choix_table">
                  <?php
                  while($table = mysqli_fetch_array($result)) {
                      echo("<option value=$table[0]>$table[0]</option>");
                  }
                  ?>
                </select>
                <input type="submit" value="Sélectionner" formaction=""/>
              </form>
            </div>
            <?php
            
            $strucTab = mysqli_query($link, "describe ".$_POST["choix_table"].";");
            $arrTabStruc = array();
            while($tableStruc = mysqli_fetch_array($strucTab)) {
              array_push($arrTabStruc,$tableStruc[0]);
            }
            // CODE AFFICHAGE TABLE (FONCTIONNEL)
            
            setcookie("table", "", time() - 3600);
            setcookie("table", $_POST["choix_table"]);
            $result = mysqli_query($link, "SELECT * FROM ".$_POST["choix_table"]);
            if($result->num_rows>0){
              echo "
              <table border='1'>
              <tr>";
              foreach($arrTabStruc as $j) {
                echo("<th>$j</th>");
              }
              echo "  
              </tr>";
              while($row = $result->fetch_assoc()) {
                echo "
                <tr>";
                foreach ($arrTabStruc as $j){
                  echo"
                  <td>".$row[$j]."</td>";
                }
                echo"
                </tr>";
              }
              echo "</table>";
            }
            else{
              echo "0 résultats";
            }
            
            
            // CODE SUPPRESSION (FONCTIONNEL)
            if(isset($_POST["suppid"])==TRUE ){
              $result1 = mysqli_real_query($link, "DELETE FROM ".$_POST["choix_table"]." WHERE ".$arrTabStruc[0]."=".$_POST["suppid"].";");
              sleep($wait);
              header($hid);
            }

            //CODE CREATION (EN COURS)
            if(isset($_POST["creaname"])){
              $q=0;
              $sql="";
              foreach($_POST["creaname"] as $creaname){
                $sql=$sql.",'".$creaname."'";
              }
              $valid_sql = substr($sql,1);
              $creainsert_teste = mysqli_query($link, "INSERT INTO ".$_POST["choix_table"]." VALUES ($valid_sql);");
              sleep($wait);
              header($hid);
            }else{}

            //CODE MODIFICATION (FONCTIONNEL)
            if(isset($_POST["modifname"])){
              $q=0;
              $sql="";
              $modifid= $_POST["modifname"][0];
              foreach($_POST["modifname"] as $modifname){
                $sql=$sql.", ".$arrTabStruc[$q]."='".$modifname."'";
                $q=$q+1;
              }
              $sql2 = substr($sql,1);
              $final_sql = "UPDATE ".$_POST["choix_table"]." SET ".$sql2." WHERE ".$arrTabStruc[0]."=".$modifid.";";
              $modifupdate = mysqli_query($link, $final_sql);
              sleep($wait);
              header($hid);
            }else{}

          ?>

      </section>
    </center>

    
    <!-- creation -->
    <center>
      <section id="main2">
        <h3>Création:</h3>
        <form method="post">
          <?php
              $c1=0;
              while($c1<count($arrTabStruc)){
                echo "<label>Indiquez '".$arrTabStruc[$c1]."': </label>";
                echo "<input type='text' name='creaname[$c1]'></input><br>";
                $c1=$c1+1;
              }
          ?>
          <input type="submit" value="Créer" formaction="home.php"></input>
        </form>
      </section>

      <!-- modifier -->
      <section id="main3">
        <h3>Modification:</h3>
        <form method="post">
          <?php
              $c1=0;
              while($c1<count($arrTabStruc)){
                echo "<label>Indiquez '".$arrTabStruc[$c1]."': </label>";
                echo "<input type='text' name='modifname[$c1]'></input><br>";
                $c1=$c1+1;
              }
          ?>
          <input type="submit" value="Créer" formaction="home.php"></input>
        </form>
      </section>
    </center>

    <!-- suppression -->
    <center>
      <section id="main">
        <h3>Suppression:</h3>
        <form method='post'>
          <label>Indiquez l'ID: </label>
          <input type='number' name='suppid' min='0'></input>
          <input type='submit' value='Supprimer' formaction='home.php'></input>
        </form>
      </section>
    </center>

     <!-- footer -->
     <footer id="mentions">
        <nav>
            <ul>
                <li><a href="index.php" style="color:#fff;">Retour à la page d'accueil</a></li>
            </ul>
        </nav>
     </footer>

  </body>
</html>
