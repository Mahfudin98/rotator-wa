<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if ($links->link_type == 1)
        <h1>{{$urut->name}}</h1>
        <h1>{{$urut->phone}}</h1>
    @else
        <h1>{{$links->phone}}</h1>
    @endif
</body>
</html>
