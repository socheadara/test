<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>
</head>
<body>
    <h1 style="text-align: center">Company or Logo</h1>
    <p style="text-align: center">Date : {{ date('d-m-Y') }}</p>
    <hr>
    <table border="0" width="100%">
        <tr>
            <td>In Date</td>
            <td>:</td>
            <td>{{ $in->in_date }}</td>
            <td>Warehouse</td>
            <td>:</td>
            <td>{{ $in->wname }}</td>
        </tr>
        <tr><td><p></p></td></tr>
        <tr>
            <td>PO NO</td>
            <td>:</td>
            <td>{{ $in->po_no }}</td>
            <td>Reference</td>
            <td>:</td>
            <td>{{ $in->reference }}</td>
        </tr>
    </table>
    <h5>Items</h5>
    <table width="100%" border="1" cellspacing="0" >
        <thead>
            <tr >
                <th style="text-align: left;padding:3px;">#</th>
                <th style="text-align: left;">Code</th>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">Quantity</th>
                <th style="text-align: center">Unit</th>

            </tr>
        </thead>
        <tbody id="data">
            @php($i=1)
            @foreach ($items as $item)
                <tr>
                    <td style="text-align: left;padding: 3px">{{ $i++ }}</td>
                    <td style="text-align: left">{{ $item->pcode }}</td>
                    <td style="text-align: left">{{ $item->pname }}</td>
                    <td style="text-align: center">{{ $item->quantity }}</td>
                    <td style="text-align: center">{{ $item->uname }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload =function(){
            print();
        }
    </script>
</body>
</html>
