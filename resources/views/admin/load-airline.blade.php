
@foreach($data['airline_by_country_code'] as $row)
    <option value="{{$row->id}}">{{$row->airline_name}} ({{$row->airline_code}})</option>
@endforeach
