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
        <h2>Sales by Shop</h2>
    </div>
    <table border="1" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            @foreach (session('records')  as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->price }}</td>
                    <td>{{ $record->quantity }}</td>
                    <td>{{ Carbon\Carbon::parse($record->created_at)->format('F d, Y') }}</td>
                    <td>{{ $record->status }}</td>
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
