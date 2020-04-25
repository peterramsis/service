<h2>Hi {{  $user->username}} </h2>
click here to reset your password

<p> 
    <a href="{{ env('APP_URL').'/reset/'.$user->email.'/'.$token }}">Reset your password</a>
</p>