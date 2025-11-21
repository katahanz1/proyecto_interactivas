<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet de Biblioteca</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            perspective: 1000px;
        }
        .card {
            width: 100%;
            max-width: 400px;
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border: 2px solid #000f3b;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.15);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 35px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            margin-bottom: 30px;
            border-bottom: 3px solid #0369a1;
            padding-bottom: 20px;
        }
        .card-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #000f3b;
            margin-bottom: 5px;
        }
        .card-header p {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .card-content {
            space-y: 20px;
        }
        .card-field {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 8px;
            border-left: 4px solid #0369a1;
        }
        .card-field label {
            display: block;
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .card-field value {
            display: block;
            font-size: 18px;
            font-weight: 600;
            color: #000f3b;
            word-break: break-word;
        }
        .card-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #9ca3af;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .card {
                box-shadow: none;
                border: 2px solid #000f3b;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Carnet de Biblioteca</h1>
                <p>Identificación de Miembro</p>
            </div>

            <div class="card-content">
                <div class="card-field">
                    <label>Nombre Completo</label>
                    <value>{{ $user->name }}</value>
                </div>

                <div class="card-field">
                    <label>Correo Electrónico</label>
                    <value>{{ $user->email }}</value>
                </div>

                <div class="card-field">
                    <label>Tipo de Cuenta</label>
                    <value>{{ $user->role === 'admin' ? 'Administrador' : 'Estudiante' }}</value>
                </div>

                <div class="card-field">
                    <label>Miembro Desde</label>
                    <value>{{ $user->created_at->format('d F, Y') }}</value>
                </div>
            </div>

            <div class="card-footer">
                <p>Este carnet se emite únicamente para propósitos de identificación.</p>
                <p>Generado: {{ date('d F, Y \a \l\a\s H:i') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
