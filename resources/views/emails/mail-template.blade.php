<!-- resources/views/emails/user.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Notification</title>
</head>
<body>
    <p>Hello, {{ $user[0] ?? 'user name' }}!</p>
    <p>Here is your notification email!</p>
</body>
</html>
