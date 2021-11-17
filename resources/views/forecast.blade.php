<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <livewire:styles />
    </head>
    <body>
        <div class="container">
            <div class="row p-5">
                <div class="col-md-5 m-auto">
                    <livewire:forecast />
                </div>
            </div>
        </div>

        <livewire:scripts />
    </body>
</html>
