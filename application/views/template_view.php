<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
        <link href="/css/styles.css" rel="stylesheet" type="text/css">  
        <script src="/js/script.js"></script>
</head>
<body>
	<?php include 'application/views/'.$content_view; ?>
</body>
</html>