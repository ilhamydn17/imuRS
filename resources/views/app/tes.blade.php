<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>tesing Larapex</title>
</head>
<body>
    <div class="container" style="width: 900px">
        {{ $chart->container()  }}
    </div>

    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
</body>
</html>
