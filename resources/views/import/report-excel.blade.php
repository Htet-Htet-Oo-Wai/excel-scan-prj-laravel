@extends('app')

@section('content')
<div class="py-3">
    <div class="mb-3">
        <h3>Report for total amount grouping by equipment type </h3>
        <table class="table table-info">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Equipment Type</th>
                    <th scope="col">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($firstReport as $index => $firstRpt)
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $firstRpt['equipment_type'] }}</td>
                        <td>{{ $firstRpt['total_amount'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mb-3">
        <h3>Report for total qty of items grouping by item subcategory </h3>
        <table class="table table-info">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item Subcategory</th>
                    <th scope="col">Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($secondReport as $index => $secondRpt)
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $secondRpt['item_sub_category'] }}</td>
                        <td>{{ $secondRpt['total_quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mb-3">
        <h3>Report for annual qty of items grouping with department and item subcategory </h3>
        <table class="table table-info">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Department</th>
                    <th scope="col">Item Sub Category</th>
                    <th scope="col">Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($thirdReport as $index => $thirdRpt)
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $thirdRpt['department'] }}</td>
                        <td>{{ $thirdRpt['item_sub_category'] }}</td>
                        <td>{{ $thirdRpt['total_quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
