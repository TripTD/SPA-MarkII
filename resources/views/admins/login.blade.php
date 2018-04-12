<!doctype html>
<html>
<head>
    <title>{{__('Log In')}}</title>
</head>
<body>
<form action="{{ route('Admins.postLogin') }}" method="post">
    {{ csrf_field() }}
    <div class="container">
        <strong>{{__('Username')}}</strong> <input type="text" name="username" value =""/><br/>
        <strong>{{__('Password')}}</strong> <input type="password" name="password" value = ""/><br/>
        <input type="submit" name="submit" value="{{__('Submit')}}">
    </div>
</form>
<br><br>
    <a href="index">{{__('Go to Index!')}}</a>
</body>
</html>