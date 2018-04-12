<!doctype html>
<html>
<head>
    <title>@yield('head')</title>
    <link rel="stylesheet" href="<?php echo asset('css/apaapa.css')?>" type="text/css">
</head>
<body>
<br><br>
<div class="container">
    @yield('display-content')
</div>
<br>
@yield('links')
<br>
<br>
@yield('footer')
<br>
<br>
</body>
</html>