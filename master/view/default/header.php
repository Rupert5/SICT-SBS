<iDOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name ="viewport" content="width=device-width, initial-scale=1">
	<title><?= htmlspecialchars($title);?></title>
	<link rel="shortcut icon" type="image/png" href="<?= PATH;?>/master/usr/img/sys/jack.png" />

	<link rel="stylesheet" type="text/css" href="<?= PATH; ?>/master/usr/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?= PATH; ?>/master/usr/css/response.css" />
</head>
<body onload="load('<?= $action;?>')">
	<section id="pageWrap" class="page-wrap main" >