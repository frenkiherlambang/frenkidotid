<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Company</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="p-12">
    <div class="flex w-full max-w-7xl flex-col justify-center items-center mx-auto gap-4">
        @foreach ($companies as $company)
        <a href="{{url('fomo/company/'.$company->activity_id)}}">
            <div class="bg-white flex-col rounded-xl w-full p-4 flex justify-center items-start shadow-xl">
                <h1 class="text-xl font-bold">{{ $company->company_name }}</h1>
                <h1 class="font-bold">{{ $company->title }}</h1>
                <p>{{ $company->content }}</p>
                <p>{{ $company->pros }}</p>
                <p>{{ $company->cons }}</p>
                <h2>Rating: {{ $company->rating }}</h2>
                <h2>Number of Dislikes: {{ $company->number_of_dislikes }}</h2>
                <h2>Number of Likes: {{ $company->number_of_likes }}</h2>
                <h2>Number of Comments: {{ $company->number_of_comments }}</h2>
            </div>
        </a>
        @endforeach
        {{ $companies->links() }}

    </div>
</body>

</html>
