<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>
    <style>
        .container .view-form .row {
            display: grid;
            grid-template-rows: auto 1fr !important;
            grid-template-columns: auto repeat(9, 1fr) !important;
        }
    </style>
</head>

<body>
    <div>
        <a link href="/">back</a>
    </div>
    <div class="container">
        <div class="view-form">
            <div class="row">
                <?php
                require "db.php";
                $pdo = new \PDO(DSN, USER, PASS);

                $statement = $pdo->prepare('SELECT * FROM images ORDER BY id DESC');
                $statement->execute();

                if ($statement->rowCount() > 0) {
                    while ($row = $statement->fetch()) {
                        echo " <td>" . " Name:" . $row['name'] . "<br>" . "</td>
                                <td>" . " Tag:" . $row['tag'] . "<br>" . "</td>
                                <td>" . " Description:" . $row['description'] . "<br>" . "</td>"
                ?>
                        <div class="div">
                            <img src="uploads/<?php echo $row['images'] ?>" width="200" height="200">

                        </div>

                <?php

                    }
                }
                ?>
            </div>

        </div>
    </div>

</body>

</html>