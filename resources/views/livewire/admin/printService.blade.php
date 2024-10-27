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
        <h2>Sales by Service</h2>
    </div>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Deceased Name</th>
                <th>Price</th>
                <th>Priest</th>
                <th>User</th>
                <th>Date</th>
                <th>Payment Method</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            @foreach (session('records')  as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->category->name }}</td>
                    <td>{{ $record->deceasedname }}</td>
                    <td>{{ $record->category->price }}</td>
                    <td>{{ $record->priest ? $record->priest->name : 'Own Priest' }}</td>
                    <td>{{ $record->userInfo->username }}</td>
                    <td>{{ Carbon\Carbon::parse($record->date)->format('F d, Y h:i:s A') }}</td>
                    <td>{{ $record->payment_method }}</td>
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
