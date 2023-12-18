<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laralisting</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />

        @routes
        @vite('resources/js/app.js')
        @inertiaHead
    </head>
    <body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-300">
        @inertia
    </body>
</html>
