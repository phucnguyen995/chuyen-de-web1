@foreach($data['airport_by_id_city_to'] as $row)
    <option value="{{$row->id}}">{{$row->airport_name}}</option>;
@endforeach