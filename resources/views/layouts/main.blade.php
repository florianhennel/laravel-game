<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mx-auto">
        <div class="grid grid-cols-4">
            <div class="col-span-4 text-3xl text-red-500 pb-8">
                Laravel game
            </div>
            <div class="col-span-3">
                @yield('content')
            </div>
            <div class="">
                Sidebars.
            </div>
        </div>
    </div>
</body>
</html>