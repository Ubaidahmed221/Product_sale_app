<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subscribe</title>
</head>
<body>

    <p>Hii, {{ $name? $name:$email }},Thank You For Subscribe {{  env('APP_NAME') }} </p>


    <a href="{{ $url }}">Unsubscribe </a>

    <p>Regards, <br> {{  env('APP_NAME') }} Team . <br> Please do not reply to this email</p>

</body>
</html>
