<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Psychotest — platform tes psikologi online dengan alat tes lengkap, penilaian berstandar, dan hasil yang langsung tersedia.">

        <title>Psychotest — Platform Tes Psikologi Online</title>

        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-white text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-200">
        @include('landing.navbar')

        <main>
            @include('landing.hero')
            @include('landing.features')
            @include('landing.steps')
        </main>

        @include('landing.footer')
    </body>
</html>
