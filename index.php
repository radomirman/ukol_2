<?php require_once "bootstrap.php";?>
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
if(isset($_POST['import'])){


    $_SESSION['message'] = [];
    foreach ($data as $item)
    {
        unset($item['id']);
        $insert = $dibi->query("INSERT INTO zaznamy",$item);


    }
    if($insert){
        $_SESSION['message']['text'] = "Data byla úspěšně vložena do databáze.";
        $_SESSION['message']['expire'] = date("Y-m-d H:i:s");
        header("location: ./");
    }
    else{
        $_SESSION['message']['text'] = "Došlo k chybě při ukládní dat.";
        $_SESSION['message']['expire'] = date("Y-m-d H:i:s");
        header("location: ./");
    }
}?>
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
<?php if(isset($_SESSION['message'])):?> <?php echo htmlspecialchars($_SESSION['message']['text'])?> <?php endif;?>
<div class="container">
    <h1 class="text-center">Seznam osob</h1>
    <section class="row">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES)?>">
            <input type="submit" name="import" class="btn btn-primary" value="Importovat data">
        </form>
    </section>
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
<script>
    $(this).ready(function (){
        $('.item').click(function (){
            $(this).toggleClass("selected");
        });
    });
</script>

<?php
if(isset($_SESSION['message'])){
    if($_SESSION['message']['expire'] < date("Y-m-d H:i:s")){
        unset($_SESSION['message']);
    }
}
?>