<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        @vite('resources/js/app.js')
        @vite('resources/css/app.css')
        @inertiaHead
    </head>
    <h1>Hola</h1>
    <body class="font-sans antialiased bg-gray-200">
        @inertia
    </body>
</html>
