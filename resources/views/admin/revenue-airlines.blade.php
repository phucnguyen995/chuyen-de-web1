@extends('master')
@section('title', 'Thống kê doanh thu')
@section('content')
<main>
<div class="container">
    <table class="table table-invers table-bordered table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th width="15%">#</th>
                <th  width="35%">Hãng</th>
                <th  width="50%">Doanh thu (VNĐ)</th>
            </tr>
            </thead>
          
            <tbody>
            <?php $i = 1; ?>
            @foreach($data['airlines'] as $key)
                <tr>
                    <td scope="row">{{$i}}</td>
                    <td>{{$key->airline_name}}</td>
                    <td>{{number_format($key->airline_revenue)}}</td>
                </tr>
               <?php $i++; ?>
            @endforeach
            </tbody>
    </table>
    <?php echo $data['airlines']->render()?>
</div>
    
</main>

@endsection