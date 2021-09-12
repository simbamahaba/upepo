<?php
use Simbamahaba\Upepo\Models\Admin;;
?>

<h5>Starter kit page</h5>
<h1>Welcome to Upepo</h1>
<h3>Admin panel for Laravel</h3>
<hr>
<?php

$admin = Admin::first();
if( null == $admin){
?>
<p>
    Apparently, there is no admin registered for your app. <br>
    Please fill the form bellow with the right credentials.
</p>
<form method="POST" action="{{ url('/kit') }}" >
    @csrf
    <label for="email">Email</label>
    <input type="email" name="email" id="email">
    <br>
    <label for="password">Password</label>
    <input type="text" name="password" id="password">
    <br>
   <input type="submit" value="Submit">
</form>

<?php
}else{
?>
<p>Admin email is <strong>{{ $admin->email }}</strong></p>
{{--                <a href="{{ route('admin.showLoginForm') }}" class="btn btn-info">Admin Login</a>--}}

<?php
}
?>
