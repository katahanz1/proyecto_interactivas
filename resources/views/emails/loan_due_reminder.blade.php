<!DOCTYPE html>
<html>
<head>
    <title>Recordatorio de Préstamo Vencido</title>
</head>
<body>
    <h1>Hola, {{ $loan->user->name }}</h1>
    <p>Este es un recordatorio de que el libro <strong>{{ $loan->book->title }}</strong> vence el <strong>{{ $loan->due_date }}</strong>.</p>
    <p>Por favor devuelve el libro a tiempo para evitar penalizaciones.</p>
    <p>¡Gracias!</p>
</body>
</html>
