<!DOCTYPE html>
<html>
<head>
    <title>Login and Register</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="login.php">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <br>
    <h1>Register</h1>
    <form method="POST" action="register.php">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>

    <br>
    <h3>Your session token: <script>document.write(document.cookie);</script></h3>

    <a href="logout.php">Logout</a>
</body>
</html>
