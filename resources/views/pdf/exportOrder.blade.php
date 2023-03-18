<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
    <style>
        table {
            border: solid 1px;
        }

        table thead th {
            text-align: left;
            border-bottom: solid 2px;
            border-bottom-style: dotted;
        }
    </style>
</head>
<body>
    <h1>Order History</h1>
    <div>
        <h2>Build your own meal plan - vegan</h2>
        @if (isset($datas['orderDetails']['meals']))
        <table>
            <thead>
                <th>{{ $datas['mealTitle'] }}</th>
            </thead>
            <tbody>
            @foreach($datas['orderDetails']['meals'] as $data)
            <tr>
                <td>{{ $data['count'] }}x {{ $data['meal_name'] }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <br/>
        @endif

        @if (isset($datas['orderDetails']['snack']))
        <table>
            <thead>
                <th>Snack</th>
            </thead>
            <tbody>
            @foreach($datas['orderDetails']['snack'] as $data)
            <tr>
                <td>{{ $data['count'] }}x {{ $data['meal_name'] }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <br/>
        @endif
        
        
        @if (isset($datas['orderDetails']['drink']))
        <table>
            <thead>
                <th>Drink</th>
            </thead>
            <tbody>
            @foreach($datas['orderDetails']['drink'] as $data)
            <tr>
                <td>{{ $data['count'] }}x {{ $data['meal_name'] }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <br/>
        @endif
        

        @if (isset($datas['orderDetails']['side']))
        <table>
            <thead>
                <th>Side</th>
            </thead>
            <tbody>
            @foreach($datas['orderDetails']['side'] as $data)
            <tr>
                <td>{{ $data['count'] }}x {{ $data['meal_name'] }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
    </body>
</html>