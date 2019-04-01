
@foreach($data['airport_by_id_city_from'] as $row)
    <option value="{{$row->id}}">{{$row->airport_name}}</option>;
@endforeach

       