<!doctype html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        @includeIf('layouts.auth.partials.css')
    </head>
    <body>
        @yield('content')
        @includeIf('layouts.auth.partials.js')
    </body>
</html>