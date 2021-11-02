<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
    <div class="container-sm">
        <header>
            <a href="{{route('home')}}">Home</a>
        </header>
        <div class="col">
            <h1>Weather in {{$city}}</h1>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Value</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>temp</td>
                    <td>{{$temp}}</td>
                </tr>
                <tr>
                    <td>pressure</td>
                    <td>{{$pressure}}</td>
                </tr>
                <tr>
                    <td>humidity</td>
                    <td>{{$humidity}}</td>
                </tr>
                <tr>
                    <td>wind</td>
                    <td>{{$wind}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
