<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>
<body>

    <p>click on below link to reset Your password : </p>
    <a href="{{ $url }}"> Click to Reset Password</a>

    <p>Regards, <br> {{  env('APP_NAME') }} Team . <br> Please do not reply to this email</p>
</body>
</html>
