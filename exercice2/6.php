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

        $min = 0;
        $max = 0;
        // when form submited
        if (isset($_POST["min"]) && isset($_POST["max"])) {
            $min = $_POST["min"];
            $max = $_POST["max"];
            
            $params = [
                'TableName' => $tableName,
                'ProjectionExpression' => 'nom, area',
                'FilterExpression' => 'area between :value_area1 and :value_area2',
                'ExpressionAttributeValues' => [
                    ':value_area1' => ['N' => $min],
                    ':value_area2' => ['N' => $max],
                ],
            ];
            
            $result = $db->scan($params);
        }
    ?>
    
    <!-- nav bar -->
    <?php  
        $page = '6';
        require 'navbar.php';
    ?>

  <main class="container" style="margin-top: 65px">
    <h5>Superficie min-max</h5>
    <form action="" role="form" method="post" >
        <div class="form-group row mt-3">
            <div class="col">
                <input type="number" name="min" class="form-control" placeholder="superficie min">
            </div>
            <div class="col">
                <input type="number" name="max" class="form-control" placeholder="superficie max">
            </div>
         </div>

        <button type="submit" name="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <hr>

    <h5>Pays dont la superficie est entre <strong><?php echo $min?></strong> et  <strong><?php echo $max?></strong></h5>

    <ul class="list-group">
        <?php foreach ($result as $e) {?>
            <li class="list-group-item"><?php echo "{$e['nom']['S']} - {$e['area']['N']}" ?></li>
        <?php } ?>
    </ul>

  </main>
</body>
</html>