<?php ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjetXML</title>
</head>
<body>
    <header>
    <?php
$xml=simplexml_load_file("http://www.ouest-france.fr/rss-en-continu.xml");
print_r($xml);
?>
    </header>
</body>
</html>