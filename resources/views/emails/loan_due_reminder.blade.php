<!DOCTYPE html>
<html>
<head>
    <title>Loan Due Reminder</title>
</head>
<body>
    <h1>Hello, {{ $loan->user->name }}</h1>
    <p>This is a reminder that the book <strong>{{ $loan->book->title }}</strong> is due on <strong>{{ $loan->due_date }}</strong>.</p>
    <p>Please return it on time to avoid penalties.</p>
    <p>Thank you!</p>
</body>
</html>
