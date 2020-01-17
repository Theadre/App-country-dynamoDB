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
        use Aws\DynamoDb\Marshaler;

        $db = new MyDynamoDB();
        
        $tableName = 'GroupeFCountry';

        $params = [
            'TableName' => $tableName,
            'ProjectionExpression' => 'languages'
        ];
        
        $result = $db->scan($params);

        $marshaler = new Marshaler();

        $langs = [];
        $langs_distinct = [];
        $ar = [];

        foreach ($result as $k => $v) {

            if (isset($v ['languages']['M'])) {
                $langs = $marshaler->unmarshalItem($v ['languages']['M']);

                // distinct langage and insert
                foreach ($langs as $k => $v) {
                    if (!in_array($k, $ar)) {
                        array_push($ar, $k);
                        array_push($langs_distinct, [$k => $v]);
                    }
                }
                
            }
        }
        
        $name_langue = 'non définie';
        $pays_result = [];
        // when form submited
        if (isset($_POST["select"])) {
            $abr_langue = $_POST["select"];

            foreach ($langs_distinct as $l) {
                if (array_keys($l)[0] == $abr_langue) {
                    $name_langue = array_values($l)[0];
                }
            }

            $params = [
                'TableName' => $tableName,
                'ProjectionExpression' => 'nom',
                'FilterExpression' => "languages.{$abr_langue} = :value_langue",
                'ExpressionAttributeValues' => [':value_langue' => ['S' => $name_langue]],
            ];
            
            // get detail country
            $pays_result = $db->scan($params);
        }
    ?>
    
    <!-- nav bar -->
    <?php  
        $page = '4';
        require 'navbar.php';
    ?>

    <main class="container" style="margin-top: 65px">

        <h5>Langues</h5>

        <form action="" role="form" method="post" >

            <div class="form-group">
                <label >Choix de langue</label>
                <select class="form-control" name="select">
                    <?php foreach ($langs_distinct as $e) {?>
                        <option value="<?php echo array_keys($e)[0] ?>"><?php echo array_values($e)[0] ?></option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <hr>

        <h5>Langue choisie: <strong><?php echo $name_langue ?></strong></h5>

        <ul class="list-group">
            <?php foreach ($pays_result as $l) {?>
                <li class="list-group-item"><?php echo $l['nom']['S'] ?></li>
            <?php } ?>
        </ul>

    </main>
</body>
</html>