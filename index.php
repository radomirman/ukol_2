<?php require_once "bootstrap.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="js/jquery-3.7.0.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .selected{
            background: red;
            font-weight: bold;
        };
    </style>
</head>
<body>
<?php
    $content = file_get_contents("https://www.3it.cz/test/data/json");
    if($content){
        $data = json_decode($content,true);
        function sortData($first,$second)
        {
            return strtotime($first['date']) - strtotime($second['date']);
        }

        //usort($data,'sortData');
    }
?>
<div class="container">
    <h1 class="text-center">Seznam osob</h1>
    <section class="row">
        <table class="table table-bordered">
            <thead class="text-center">
            <tr>
                <th>Id</th>
                <th>Jméno</th>
                <th>Přijmení</th>
                <th>Datum</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $item):?>
                <tr class="item">
                    <td><?php echo htmlspecialchars($item['id'],ENT_QUOTES)?></td>
                    <td><?php echo htmlspecialchars($item['jmeno'],ENT_QUOTES)?></td>
                    <td><?php echo htmlspecialchars($item['prijmeni'],ENT_QUOTES)?></td>
                    <td><?php echo htmlspecialchars($item['date'],ENT_QUOTES)?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </section>
</div>
</body>
</html>
<?php

foreach ($data as $item)
{
    unset($item['id']);
    $insert = $dibi->query("INSERT INTO zaznamy",$item);


}
if($insert){
    echo "Data byla uložena do databáze. ";
}



?>
<script>
    $(this).ready(function (){
        $('.item').click(function (){
            $(this).toggleClass("selected");
        });
    });
</script>