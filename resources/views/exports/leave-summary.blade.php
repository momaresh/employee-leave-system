<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leave Summary Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { padding: 8px; border: 1px solid #333; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Leave Summary Report</h2>
    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee No.</th>
                <th>Mobile</th>
                <th>Total Leaves</th>
                <th>Last Leave Date</th>
                <th>Last Leave Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $emp)
                <tr>
                    <td>{{ $emp->name }}</td>
                    <td>{{ $emp->number }}</td>
                    <td>{{ $emp->mobile }}</td>
                    <td>{{ $emp->total }}</td>
                    <td>{{ $emp->last_date }}</td>
                    <td>{{ $emp->last_type }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
