<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('public') }}/assets/images/favicon.ico">
    <!-- App css -->
    <link href="{{ url('public') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('public') }}/assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('public') }}/assets/css/errorpage.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="error-page">
        <div>
            <h1 data-h1="404">404</h1>
            <p data-p="NOT FOUND">NOT FOUND</p>
            <p>{{ $exception->getMessage() }}</p>
        </div>
    </div>
    <div id="particles-js"><a class="back" href="{{ route('dashboard') }}">GO BACK</a></div>
</body>

</html>