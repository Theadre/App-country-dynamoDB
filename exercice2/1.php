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
        if (isset($_POST["select"])) {
            $selected_region = $_POST["select"];

            $params = [
                'TableName' => $tableName,
                'ProjectionExpression' => 'nom',
                'KeyConditionExpression' => '#region = :region',
                'ExpressionAttributeNames'=> [ '#region' => 'region' ],
                'ExpressionAttributeValues' => [
                    ':region' => ['S' => $selected_region], 
                ],
            ];
            
            $result = $db->query($params);
        }
    ?>
    
    <!-- nav bar -->
    <?php  
        $page = '1';
        require 'navbar.php';
    ?>

  <main class="container" style="margin-top: 65px">

    <form action="" role="form" method="post" >
        <div class="form-group">
            <label >Choix de région</label>
            <select class="form-control" name="select">
                <option>Antarctic</option>
                <option>Europe</option>
                <option>Africa</option>
                <option>Oceania</option>
                <option>Asia</option>
                <option>Americas</option>
            </select>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <hr>

    <h5>Region : <?php echo isset($_POST["select"]) ? $_POST["select"] : '--'?></h5>

    <ul class="list-group">
        <?php foreach ($result as $e) {?>
            <li class="list-group-item"><?php echo $e['nom']['S'] ?></li>
        <?php } ?>
    </ul>

  </main>
</body>
</html>