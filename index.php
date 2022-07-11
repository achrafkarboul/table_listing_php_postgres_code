<?php
include("affiche.php");
$newObj = new pdch();
$pdchs = $newObj->getpdchs();
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
        <div class="well">
            <h2>connexion à la base de données</h2>
        </div>
        <table id="pdch_grid" class="table" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>pdch</th>
                <th>stc</th>
                <th>type</th>
                <th>pays</th>
                <th>nbr</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pdchs as $key => $pdch) : ?>
                <tr>
                    <td><?php echo $pdch['id_pdch'] ?></td>
                    <td><?php echo $pdch['id_stc'] ?></td>
                    <td><?php echo $pdch['type_prise'] ?></td>
                    <td><?php echo $pdch['code_pays'] ?></td>
                    <td><?php echo $pdch['nbr_v'] ?></td>
                    <td>
                        <div class="btn-group" data-toggle="buttons"><a href="#" target="_blank"
                                                                        class="btn btn-warning btn-xs">Edit</a><a
                                    href="#" target="_blank" class="btn btn-danger btn-xs">nader</a><a href="#"
                                                                                                       target="_blank"
                                                                                                       class="btn btn-primary btn-xs">View</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
</html>
