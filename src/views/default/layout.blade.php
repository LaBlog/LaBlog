<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>

    <!-- Add Meta Info for SEO -->
    @if ($post->description)
        <meta name="description" content="{{ $post->description }}">
    @endif
    @if ($post->author)
        <meta name="author" content="{{ $post->author }}">
    @endif
</head>
<body>
    @yield('content')
</body>
</html>