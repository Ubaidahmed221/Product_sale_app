<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifcation Email</title>
</head>
<body>

    <p>Hii, {{ $name }}</p>
    <p>Click on below link to Verify Your Account : </p>

    <a href="{{ $url }}">Click To Verify </a> 

    <p>Regards, <br> {{  env('APP_NAME') }} Team . <br> Please do not reply to this email</p>

</body>
</html>
