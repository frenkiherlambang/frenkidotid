<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
    <title>Folders</title>
    @vite([
        'resources/js/app.js',
        'resources/css/app.css',
        ])
</head>
<body>
    <div class="flex max-w-4xl flex-wrap mx-auto gap-2 my-12 items-center justify-center">
    @foreach($dirs as $dir)
     {{-- {{ $dir}} --}}
     <div class="border p-4">

         <a href="{{ url('snapshots/' . str_replace('capture/', '', $dir))}}">{{ $dir }}</a>
     </div>
    @endforeach
    </div>
</body>
</html>
