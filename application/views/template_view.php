<!DOCTYPE html>
<?php
use ScssPhp\ScssPhp\Compiler;
$scss = new Compiler();
$scss->setFormatter('ScssPhp\ScssPhp\Formatter\Compressed');
$scss->setImportPaths('css/');
file_put_contents('css/style.css', $scss->compile('@import "style.scss";'));
?>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
        <link href="/css/style.css" rel="stylesheet" type="text/css">  
        <script src="/dist/bundle.js"></script>
</head>
<body>
	<?php include 'application/views/'.$content_view; ?>
</body>
</html>