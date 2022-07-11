<?php
include("affiche.php");
$newObj = new pdch();
$test = $newObj->getId();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>Simple table listing using Postgres database</title>
</head>
<body>
<div class="container">
    <div class="col-sm-6" style="padding-top:50px;">
        <div class="well">
            <h2>vérification</h2>
        </div>
        <form method="get" name="f" id="f">
            <table border="1" bordercolor="#000000" bgcolor="#999999">
                <tr>
                    <td colspan="2">
                        <akuvit></akuvit>
                    </td>
                </tr>
                <tr>
                    <td>id_Borne</td>
                    <td><input name="idB" type="text" id="idB" maxlength="10"></td>
                </tr>
                <tr>
                    <td><input name="b1" type="submit" onclick="function getId() {
                    }
                    getId()" id="b1" value="ajouter"></td>
                    <td><input name="b2" type="reset" id="b2" value="Annuler"></td>
                </tr>
            </table>
        </form>
        <table id="response" class="table" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>pdch</th>
                <th>cmnt</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($test as $key => $pdch) : ?>
                <tr>
                    <td><?php echo $pdch['resultat'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>


    </div>
</div>
</div>
</body>
</html>
