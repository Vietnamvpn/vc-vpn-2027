<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $pageTitle ?? 'VC VPN 2027' ?></title>
    <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/app.css">
    <?php if (isset($extraCss)): ?>
        <link rel="stylesheet" href="/assets/css/<?= $extraCss ?>.css">
    <?php endif; ?>
</head>
<body>