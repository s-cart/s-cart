
@php
/*
This view use render attribute product
$details: is list attributes group by groupId
$groups: is group attribute
*/
@endphp

@foreach ($details as $groupId => $detailsGroup)
    <br><b><label> {!! $groups[$groupId] !!}</label></b>:
    @foreach ($detailsGroup as $k => $detail)
        <label class="radio-inline"><input {{ (($k == 0) ? "checked" : "") }} type="radio" name="form_attr[{{ $groupId }}]" value="{{ $detail->name }}">{{ $detail->name }}</label>
    @endforeach
@endforeach