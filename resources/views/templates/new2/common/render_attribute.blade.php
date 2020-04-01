@foreach ($details as $groupId => $detailsGroup)
    <br><b><label> {!! $groups[$groupId] !!}</label></b>:
    @foreach ($detailsGroup as $k => $detail)
        <label class="radio-inline"><input {{ (($k == 0) ? "checked" : "") }} type="radio" name="form_attr[{{ $groupId }}]" value="{{ $detail->name }}">{{ $detail->name }}</label>
    @endforeach
@endforeach