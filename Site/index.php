<html>
<head>
  <link rel="stylesheet" text="text/css" href="index.css">
<title>Test</title>
</head>
<body style="width:70%;margin:auto;">

<?php
require 'pages/data/Donnees.inc.php';
  $servername = "localhost";
  $username = "root";
  $password = "";
  // Create connection
  $conn = new mysqli($servername, $username, $password);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  // Create database
  if ($conn->select_db('Cocktail') === FALSE) {

    if(!isset($_POST['submit'])){
      ?>
        <h1 style="text-align:center;">Le base de données COCKTAIL va être généree à l'aide du magnifique cours de PHP-MySQL conçu par le fameux NOURREDINE ZEJLI.</h1>
        <form action="" method="post" style="width:100%;text-align:center;">
        <input type="submit" name="submit" value="Prêt?"  />
      </form>
      <?php
      $conn->close();
      exit(0);
    }
    /*

    CREATION DE LA BASE DE DONNÉES COCKTAIL

    */
    if($conn->query("CREATE DATABASE Cocktail") === TRUE){
      echo "Database created successfully<br>";
      if(($conn->select_db('Cocktail') === FALSE)){
        //SI LA BASE
      echo "Cannot access Database" . $conn->error;
      exit(-1);
      }
      else{
        $conn->query("SET NAMES UTF8");
        /*

          CREATION DE LA TABLE COCKTAIL

        */
        $sql = "CREATE TABLE Cocktail (
                      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                      titre TEXT NOT NULL,
                      recette TEXT NOT NULL,
                      preparation TEXT NOT NULL,
                      ingredients TEXT NOT NULL

                    )";
        if($conn->query($sql) !== TRUE){
          /*

          ERREUR CREATION DE LA TABLE COCKTAIL

          */
          echo "Error creating table Cocktail: " . $conn->error;
          exit(-1);
        }
        echo "Table Cocktail created successfully<br>";

        /*
        INSERTION DES COCKTAILS DANS LA TABLE COCKTAIL
        */
        foreach ($Recettes as $cocktail) {
          $titre = $conn->real_escape_string($cocktail['titre']);
          $preparation = $conn->real_escape_string($cocktail['preparation']);
          $recette = $conn->real_escape_string($cocktail['ingredients']);
          foreach($cocktail['index'] as $index){
            $titre = $conn->real_escape_string($cocktail['titre']);
            $ingredients = $conn->real_escape_string($index);
            $sql = "INSERT INTO Cocktail (titre, recette , ingredients, preparation) VALUES ('" .utf8_encode($titre) . "','". $recette."','". $ingredients."','".$preparation . "')";
            if (!($conn->query($sql) === TRUE)) {
              //ERREUR INSERTION DANS LA BDD
              echo "Error: " . $sql . "<br>" . $conn->error;
              exit(-1);
            }
          }
        }
      echo "<h1>La magie de Zejli vient d'operer !</h1>";
    }
    }
      else {
        // ERREUR CREATION DE LA BASE DE DONNÉES
        echo "Error creating database: " . $conn->error;
      }
  }
  else{
// CODE HERE
echo '<ul>';
foreach ($Hierarchie as $types) {
  if(is_array($types['super-categorie'])){
    echo '<ul>';
    foreach ($types['super-categorie'] as $types2) {
      // code...
      echo '<li>'.$types2."</li>";
    }
    echo '</ul>';
  }
}
echo'</ul>';
?>


<?php
  }
  $conn->close();
?>
</body>
</html>
