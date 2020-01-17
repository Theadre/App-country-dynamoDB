<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Exercice 2</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <!-- logic for submit form -->
    <?php
        require '../MyDynamoDB.php';

        $db = new MyDynamoDB();
        
        $tableName = 'GroupeFCountry';

        $params = [
            'TableName' => $tableName,
            'ProjectionExpression' => 'nom'];
        // get all countries    
        $nom_pays = $db->scan($params);

        $result = [];
        $detail_pays = [];
        $pays = 'non définie';
        // when form submited
        if (isset($_POST["select"])) {
            $pays = $_POST["select"];

            $params = [
                'TableName' => $tableName,
                'FilterExpression' => 'nom = :value_nom',
                'ExpressionAttributeValues' => [':value_nom' => ['S' => $pays]],
            ];
            
            // get detail country
            $detail_pays = $db->scan($params);
        }
    ?>
    
    <!-- nav bar -->
    <?php  
        $page = '3';
        require 'navbar.php';
    ?>

  <main class="container" style="margin-top: 65px">
    <h5>Pays</h5>
   <form action="" role="form" method="post" >

        <div class="form-group">
            <label >Choix du pays</label>
            <select class="form-control" name="select">
                <?php foreach ($nom_pays as $e) {?>
                    <option><?php echo $e['nom']['S'] ?></option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <hr>

    <h5>Informations sur le pays : <strong><?php echo $pays?></strong></h5>

    <ul class="list-group">
        <?php foreach ($detail_pays as $e) { ?>
            <li class="list-group-item">Région : <?php echo $e['region']['S'] ?></li>
            <li class="list-group-item">Nom : <?php echo $e['nom']['S'] ?></li>
            <li class="list-group-item">Langues : 
            <?php 
            foreach (array_values($e['languages'])[0] as $language) {
                echo "{$language['S']}, ";
            }
            ?></li>
            <li class="list-group-item">Zone : <?php echo $e['area']['N'] ?></li>
        <?php } ?>
    </ul>

  </main>
</body>
</html>