<!DOCTYPE html>
<html>
<head>
    <title>Your Account Credentials</title>
</head>
<body>
    <h1>Hello, {{ $name }}!</h1>
    <p>Thank you for choosing our application. We are excited to have you join our community.</p>
    <p>Please find your login credentials below. We strongly recommend changing your password upon your first login for security purposes.</p>
    <p><strong>Username:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>If you have any questions or need assistance, please do not hesitate to contact our support team.</p>
    <p>Welcome aboard!</p>

    <p>URL: <a href="http://127.0.0.1:8000/login">Click here to login..</a></p>
</body>
</html>
