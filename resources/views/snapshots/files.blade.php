<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">

    <title>Files</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body x-data="{
    isModalOpen: true,
}" class="max-w-7xl mx-auto my-12">


    <div class="flex text-3xl  items-center my-2 justify-around w-full">
        <a href="{{ url('snapshots') }}" class="">
            <svg viewBox="0 0 24 24" class="w-12 h-12" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" d="m14 18l-6-6l6-6l1.4 1.4l-4.6 4.6l4.6 4.6L14 18Z" />
            </svg>
        </a>
        Ada sebanyak {{ count($files) }} CCTV
    </div>

    <div class="cctvs flex flex-wrap gap-2 items-center justify-center">

        @foreach ($files as $file)
            <div class="flex flex-col p-4 items-center justify-center rounded-xl shadow-xl border">
                {{-- <a href="{{ asset('storage/' . $file) }}">
                    <img src="{{ asset('storage/' . $file) }}" alt="" class="w-48 object-cover" />

                </a> --}}
                <a href="https://bucket.frenki.id/{{$file}}">
                    <img src="https://bucket.frenki.id/{{$file}}" alt="" class="w-48 object-cover" />
                </a>


                <p class="text-center text-sm">{{ explode($date . '/', $file)[1] }}</p>
            </div>
        @endforeach
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var lightbox = new SimpleLightbox('.cctvs a', {});
            });

        </script>
</body>

</html>
