<html>
<head>
    <title>Task</title>
</head>
<body>
    
<form name="register" method="post" action="/register">
     @csrf
    <p>Login:<br>
        <input name="login" type="text">
    <p>Email:<br>
        <input name ="email" type="text">
    <p>Пароль:<br>
        <input name ="pass" type="text">
    <p>Повтор пароля:<br>
        <input name ="pwag" type="text">
    </p>
    <button>Reg</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

</form>
</body>
</html>
