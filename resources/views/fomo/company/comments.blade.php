<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Company | Comments</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="p-12">
    <div class="flex max-w-7xl flex-wrap justify-center items-center mx-auto gap-2">
        @foreach ($data as $comment)
            <div class="bg-white  rounded-xl flex-col w-full p-4 gap-4 flex justify-start items-start shadow-xl">
                <p>{{ $comment->inner->value }}</p>

                <span class="font-bold">{{ '@'.$comment->inner->user->username }}</span>
                <span class="text-sm">{{ \Carbon\Carbon::parse($comment->inner->creationTime)->format('d F Y H:m:s') }}</span>
                @foreach ($comment->inner->comments as $comment)
                    <div class="bg-white rounded-xl w-full p-4 flex flex-col justify-center items-start shadow-xl" >
                        <p>{{ $comment->value }}</p>
                        <span class="font-bold">{{ '@'.$comment->user->username }}</span>
                        {{ \Carbon\Carbon::parse($comment->creationTime)->format('d F Y H:m:s') }}
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</body>

</html>
