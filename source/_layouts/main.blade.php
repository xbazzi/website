<!DOCTYPE html>
<html lang="{{ $page->language ?? 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="{{ $page->getUrl() }}">
    <meta name="description" content="{{ $page->description }}">
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>{{ $page->title }}</title>
    <script src="https://kit.fontawesome.com/6faa1ef8ce.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
    <script defer src="{{ mix('js/main.js', 'assets/build') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/night-owl.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js"></script>

    <!-- and it's easy to individually load additional languages -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/languages/go.min.js"></script>

    <script>hljs.highlightAll();</script>
</head>

<body class="text-gray-900 py-10 antialiased">
    <div class="flex w-full h-auto items-center justify-center">
        <a href="/">
            <img class="mx-auto mb-4" src="/assets/img/xbazzi_ascii.png" alt="">
        </a>
    </div>
    @yield('body')
    <!-- Cloudflare Web Analytics -->
    <script defer src='https://static.cloudflareinsights.com/beacon.min.js'
        data-cf-beacon='{"token": "851787a3fc454e6e83a8ad922bcfe266"}'></script><!-- End Cloudflare Web Analytics -->
</body>

</html>
