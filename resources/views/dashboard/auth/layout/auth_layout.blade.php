<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Login</title>
    @include('dashboard.auth.layout.styles')
</head>
<body class="hold-transition login-page">
@yield('content')
@include('dashboard.auth.layout.scripts')
</body>
</html>
