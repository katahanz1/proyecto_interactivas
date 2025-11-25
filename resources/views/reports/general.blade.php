<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General de Biblioteca</title>
    <style>
        body { font-family: sans-serif; padding: 20px; color: #333; }
        h1 { color: #000f3b; border-bottom: 2px solid #0369a1; padding-bottom: 10px; }
        h2 { color: #0369a1; margin-top: 20px; }
        .stats-grid { display: table; width: 100%; margin-bottom: 20px; }
        .stat-card { display: table-cell; width: 25%; padding: 10px; background: #f3f4f6; border: 1px solid #e5e7eb; text-align: center; }
        .stat-value { font-size: 24px; font-weight: bold; color: #000f3b; }
        .stat-label { font-size: 12px; color: #6b7280; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; border-bottom: 1px solid #e5e7eb; text-align: left; font-size: 12px; }
        th { background-color: #000f3b; color: white; }
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 10px; color: white; }
        .bg-success { background-color: #10b981; }
        .bg-warning { background-color: #f59e0b; }
        .bg-danger { background-color: #ef4444; }
        .bg-info { background-color: #3b82f6; }
        .bg-purple { background-color: #8b5cf6; }
    </style>
</head>
<body>
    <h1>Reporte General del Sistema</h1>
    <p>Generado el: {{ date('d/m/Y H:i') }}</p>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_books'] }}</div>
            <div class="stat-label">Total Libros</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_students'] }}</div>
            <div class="stat-label">Estudiantes</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['active_loans'] }}</div>
            <div class="stat-label">Préstamos Activos</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['overdue_loans'] }}</div>
            <div class="stat-label">Vencidos</div>
        </div>
    </div>

    <h2>Libros por Categoría</h2>
    <table>
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Cantidad de Libros</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats['books_by_category'] as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->books_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Actividad Reciente</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Estudiante</th>
                <th>Libro</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats['recent_activity'] as $loan)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($loan->updated_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ $loan->user->name }}</td>
                    <td>{{ $loan->book->title }}</td>
                    <td>
                        @php
                            $statusMap = [
                                'borrowed' => ['label' => 'Prestado', 'class' => 'bg-warning'],
                                'returned' => ['label' => 'Devuelto', 'class' => 'bg-success'],
                                'requested' => ['label' => 'Solicitado', 'class' => 'bg-info'],
                                'return_requested' => ['label' => 'Dev. Pendiente', 'class' => 'bg-purple'],
                            ];
                            $status = $statusMap[$loan->status] ?? ['label' => ucfirst($loan->status), 'class' => 'bg-gray'];
                        @endphp
                        <span class="badge {{ $status['class'] }}">{{ $status['label'] }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
