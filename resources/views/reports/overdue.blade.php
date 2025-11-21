<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overdue Books Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            padding: 40px;
            color: #1f2937;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 28px;
            font-weight: 700;
            color: #000f3b;
            margin-bottom: 10px;
            border-bottom: 3px solid #0369a1;
            padding-bottom: 15px;
        }
        .report-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            font-size: 14px;
            color: #6b7280;
        }
        .report-meta p {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #000f3b;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border: none;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        tbody tr:hover {
            background-color: #f3f4f6;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
        }
        .empty-state p {
            font-size: 16px;
        }
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Overdue Books Report</h1>
        <div class="report-meta">
            <p><strong>Generated:</strong> {{ date('F d, Y') }}</p>
            <p><strong>Time:</strong> {{ date('H:i:s') }}</p>
        </div>

        @if(count($overdueLoans) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Book Title</th>
                        <th>Loan Date</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($overdueLoans as $loan)
                        <tr>
                            <td>{{ $loan->user->name }}</td>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->due_date)->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>No overdue loans found.</p>
            </div>
        @endif
    </div>
</body>
</html>
