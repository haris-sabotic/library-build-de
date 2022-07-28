<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
</head>
<body>
    <form action="{{route('setNewPassword')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <input name="token" value="{{ $token }}" type="hidden" />

        <input type="password" name="password" placeholder="Password">
        <br>
        <input type="password" name="passwordConfirm" placeholder="Confirm password">
        <br>
        <br>
        <button type="submit">SUBMIT</button>
    </form>
</body>
</html>