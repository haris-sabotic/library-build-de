<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="font-sans text-gray-900 antialiased">
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-login">
    <div>
        <a href="/">
                <div class="flex flex-row">
    <img src="/storage/image/logo.svg" alt="" class="h-[60px]">
    <p class="text-white font-semibold text-[22px] mt-[20px] pl-[16px]">Online biblioteka</p>
</div>
            </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
        </div>

        <form action="{{route('setNewPassword')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <input name="token" value="{{ $token }}" type="hidden" />

            <div>
                <label class="block font-medium text-sm text-gray-700" for="password">
    Password
</label>

                <input class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="password" type="password" name="password" required="required" autofocus="autofocus">
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700" for="passwordConfirm">
    Confirm password
</label>

                <input class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" id="passwordConfirm" type="password" name="passwordConfirm" required="required" autofocus="autofocus">
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Reset password
</button>
            </div>
        </form>
    </div>
</div>
        </div>
    

</body>
</html>