<!-- resources/views/livewire/admin/service-print-table.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Records</title>
    <style>
        /* Add any styles you want for printing */
        body {
            font-family: Arial, sans-serif;
        }
        table{
            border-collapse: collapse;
            width: 100%;
        }
    </style>
</head>
<body>
    <div style="display: flex; justify-content: center">
        <h2>Sales by Niche</h2>
    </div>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>BUILDING NAME</th>
                <th>NICHE NUMBER</th>
                <th>LEVEL</th>
                <th>CUSTOMER</th>
                <th>STATUS</th>
                <th>PRICE</th>
                <th>TOTAL PAID</th>
            </tr>
        </thead>
        <tbody>

            @foreach (session('records')  as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->buildingInfo->name }}</td>
                    <td>{{ $record->niche_number }}</td>
                    <td>{{ $record->level }}</td>
                    <td>{{ $record->customerInfo?->username }}</td>

                    <td>{{ $record->status }}</td>
                    <td>{{ $record->price }}</td>

                    <td>{{ $record->total_paid }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
