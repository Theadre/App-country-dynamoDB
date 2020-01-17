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

        $result = [];
        // when form submited
        if (isset($_POST["min"]) && isset($_POST["max"])) {
            $min = $_POST["min"];
            $max = $_POST["max"];

            $params = [
                'TableName' => $tableName,
                'ProjectionExpression' => 'nom, area'
            ];
            
            $result = $db->scan($params);

            usort($result, function($a, $b) {
                return $b['area']['N'] - $a['area']['N'];
            });
            
            $result = array_slice($result, $min, $max - $min); 
        }
    ?>
    
    <!-- nav bar -->
    <?php  
        $page = '1';
        require 'navbar.php';
    ?>

  <main class="container" style="margin-top: 65px">
    <h5>Position min-max</h5>
    <form action="" role="form" method="post" >
        <div class="form-group row mt-3">
            <div class="col">
                <input type="text" name="min" class="form-control" placeholder="position min">
            </div>
            <div class="col">
                <input type="text" name="max" class="form-control" placeholder="position max">
            </div>
         </div>

        <button type="submit" name="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <hr>

    <h5>Résultat :</h5>

    <ul class="list-group">
        <?php foreach ($result as $e) {?>
            <li class="list-group-item"><?php echo "{$e['nom']['S']} - {$e['area']['N']}" ?></li>
        <?php } ?>
    </ul>

  </main>
</body>
</html>