@extends('master')
@section('title', 'Thống kê lưu lượng máy bay đến - đi sân bay')
@section('content')
<main>
<div class="container">
    <h3 class="text-center alert alert-success">Thống kê lưu lượng máy bay đến các sân bay </h3>

    <h4>Số lượng máy bay đến nhiều nhất :</h4>
    
    <table class="table table-invers table-bordered table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th width="5%">#</th>
                <th  width="35%">Tên sân bay</th>
                <th  width="30%" style="background:#c79810;">Số lần máy bay đến</th>
                <th  width="30%">Số lần máy bay đi</th>
            </tr>
            </thead>
          
            <tbody>
            <?php $i = 1; ?>
            @foreach($data['get_aiport_from_paginate'] as $key)
                <tr>
                    <td scope="row">{{$i}}</td>
                    <td>{{$key->airport_name}}</td>
                    <td>{{$key->amount_airline_from}}</td>
                    <td>{{$key->amount_airline_to}}</td>
                </tr>
               <?php $i++; ?>
            @endforeach
            </tbody>
    </table>

    <h4>Số lượng máy bay đi nhiều nhất :</h4>
    
    <table class="table table-invers table-bordered table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th width="5%">#</th>
                <th  width="35%">Tên sân bay</th>
                <th  width="30%">Số lần máy bay đến</th>
                <th  width="30%" style="background:#c79810;">Số lần máy bay đi</th>
            </tr>
            </thead>
          
            <tbody>
            <?php $i = 1; ?>
            @foreach($data['get_aiport_to_paginate'] as $key)
                <tr>
                    <td scope="row">{{$i}}</td>
                    <td>{{$key->airport_name}}</td>
                    <td>{{$key->amount_airline_from}}</td>
                    <td>{{$key->amount_airline_to}}</td>
                </tr>
               <?php $i++; ?>
            @endforeach
            </tbody>
    </table>
    <?php echo $data['get_aiport_to_paginate']->render()?>
</div>
    
</main>
@endsection