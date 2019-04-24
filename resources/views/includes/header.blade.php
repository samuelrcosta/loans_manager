<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.jpg') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    @if(isset($title) && !empty($title))
    <title>{{ $title }}</title>
    @else
    <title>Loans Manager</title>
    @endif

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('css/material-dashboard.min.css') }}?v={{ filemtime('css/material-dashboard.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}?v={{ filemtime('css/style.css') }}" rel="stylesheet" />

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</head>