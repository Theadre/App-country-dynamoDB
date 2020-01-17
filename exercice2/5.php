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
        
        $letter = 'non définie';

        $alphas = range('A', 'Z');

        $result = [];
        // when form submited
        if (isset($_POST["select"])) {
            $letter = $_POST["select"];

            $params = [
                'TableName' => $tableName,
                'ProjectionExpression' => 'nom',
                'FilterExpression' => 'begins_with( nom, :value_letter)',
                'ExpressionAttributeValues' => [':value_letter' => ['S' => $letter]],
            ];
            
            // get detail country
            $result = $db->scan($params);
        }
    ?>
    
    <!-- nav bar -->
    <?php  
        $page = '5';
        require 'navbar.php';
    ?>

    <main class="container" style="margin-top: 65px">

        <h5>Lettres</h5>

        <form action="" role="form" method="post" >

            <div class="form-group">
                <label >Choix de la lettre</label>
                <select class="form-control" name="select">
                    <?php foreach ($alphas as $e) {?>
                        <option><?php echo $e ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <hr>

        <h5>Pays dont le nom commence par: <strong><?php echo $letter?></strong></h5>

        <ul class="list-group">
            <?php foreach ($result as $e) {?>
                <li class="list-group-item"><?php echo $e['nom']['S'] ?></li>
            <?php } ?>
        </ul>

    </main>
</body>
</html>