<?php ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <script src="js/jquery-min.js"></script>
    <script src="js/autobase.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="page-header" align="center">
    <h1 class="text-muted"><strong>Автомагазин</strong></h1>
</div>
<div class="container">
    <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Автомагазин</a>
            </div>
            <ul class="nav navbar-nav">
          <li class="nav-item"><a class="nav-item nav-link" href="/base">База данных автомобилей</a></li>
          <li class="nav-item"><a class="nav-item nav-link" href="/contacts">Контакты</a></li>
      </ul>
    </nav>
    <h2><?php echo $header; ?></h2>
    <br>
    <?php echo $content; ?>
    <br>
</div>
</body>
</html>