@foreach ($details as $groupId => $detailsGroup)
    <br><b><label> {!! $groups[$groupId]??'Not found' !!}</label></b>:
    @foreach ($detailsGroup as $k => $detail)
    @php
        $valueOption = $detail->name.'__'.$detail->add_price;
    @endphp
        <label class="radio-inline"><input {{ (($k == 0) ? "checked" : "") }} type="radio" name="form_attr[{{ $groupId }}]" value="{{ $valueOption }}">
            {!! sc_render_option_price($valueOption) !!}
        </label>
    @endforeach
@endforeach