<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>精弘网络失物招领公测版</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="openid" content="{{ $openid }}">
</head>
<body>
    <div id="app"></div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>