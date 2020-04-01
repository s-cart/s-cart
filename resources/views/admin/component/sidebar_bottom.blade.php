<style type="text/css">
#summary li {
    font-size: 11px;
    color: #9d9d9d;
    padding: 5px 10px;
    border-bottom: 1px dotted #373737;
}
#summary ul, #summary li {
    padding: 0;
    margin: 0;
    list-style: none;
}
#summary {
    border-radius: 2px;
    color: #808b9c;
    background: #2e3a47;
    margin: 15px 10px;
    padding: 5px 0;
}
#summary div:first-child {
    margin-bottom: 4px;
}
#summary li {
    font-size: 11px;
    color: #9d9d9d;
    padding: 5px 10px;
    border-bottom: 1px dotted #373737;
}
#summary .progress {
    height: 3px;
    margin-bottom: 0;
}

.progress {
    overflow: hidden;
    height: 18px;
    margin-bottom: 18px;
    background-color: #f5f5f5;
    border-radius: 3px;
    -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
}
.progress-bar-default {
    background-color: #000;
}

@media (min-width: 768px) {
    .sidebar-collapse #summary {
        display: none !important;
        -webkit-transform: translateZ(0);
    }
}

</style>
@php
    $totalOrder = \App\Models\ShopOrder::count();
    $styleStatus = \App\Models\ShopOrder::$mapStyleStatus;
@endphp
@if ($totalOrder)
@php
    $arrStatus = \App\Models\ShopOrderStatus::pluck('name','id')->all();
    $groupOrder = (new \App\Models\ShopOrder)->all()->groupBy('status');
@endphp
    <div id="summary">
    <ul>
        @foreach ($groupOrder as $status => $element)
        @php
            $style = $styleStatus[$status]??'light';
            $percent = floor($element->count() * 100/$totalOrder);
        @endphp
            <li>
                <div>Orders {{ $arrStatus[$status]??'' }} <span class="pull-right">{{ $percent }}%</span></div>
                <div class="progress">
                <div class="progress-bar progress-bar-{{ $style }}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: {{ $percent }}%"> <span class="sr-only">{{ $percent }}%</span></div>
                </div>
            </li>
        @endforeach

    </ul>
    </div>

@endif
