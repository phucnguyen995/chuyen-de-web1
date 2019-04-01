<option selected disabled>--Thành phố--</option>
@foreach($data['city_by_id_country'] as $row)
    <option value="{{$row->id}}">{{$row->city_name}} ({{$row->city_code}})</option>
@endforeach