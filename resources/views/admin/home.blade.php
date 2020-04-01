@extends('admin.layout')



@section('main')

<div class="row">

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ trans('admin.total_order') }}</span>
              <span class="info-box-number">{{ number_format($orders->count()) }}</span>
              <a href="{{ route('admin_order.index') }}" class="small-box-footer">
                  {{ trans('admin.more') }}&nbsp;
                  <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-tags"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ trans('admin.total_product') }}</span>
              <span class="info-box-number">{{ number_format($products->count()) }}</span>
              <a href="{{ route('admin_product.index') }}" class="small-box-footer">
                  {{ trans('admin.more') }}&nbsp;
                  <i class="fa fa-arrow-circle-right"></i>
              </a>

            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ trans('admin.total_customer') }}</span>
              <span class="info-box-number">{{ number_format($users->count()) }}</span>
              <a href="{{ route('admin_customer.index') }}" class="small-box-footer">
                  {{ trans('admin.more') }}&nbsp;
                  <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->



        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-map-signs"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">{{ trans('admin.total_blogs') }}</span>
              <span class="info-box-number">{{ number_format($blogs->count()) }}</span>
              <a href="{{ route('admin_news.index') }}" class="small-box-footer">
                  {{ trans('admin.more') }}&nbsp;
                  <i class="fa fa-arrow-circle-right"></i>
              </a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->


      </div>


{{-- Chart --}}
<div class="row">

  <div class="col-md-12">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin.order_month') }}</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>

      <div class="box-body table-responsive no-padding box-primary">
        <div class="box">
          <canvas id="chart-days-in-month" width="700" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>


  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin.order_year') }}</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>

      <div class="box-body table-responsive no-padding box-primary">
          <div class="box">
            <canvas id="chartjs-1" width="600" height="150"></canvas>
          </div>
      </div>
    </div>
  </div>
  </div>
{{-- //End chart --}}


<div class="row">

{{-- Top order --}}
@php
  $topOrder = $orders->with('orderStatus')->orderBy('id','desc')->limit(10)->get();
@endphp

  <div class="col-md-6">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin.top_order_new') }}</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>

      <div class="box-body table-responsive no-padding box-primary">
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>{{ trans('order.id') }}</th>
                    <th>{{ trans('order.email') }}</th>
                    <th>{{ trans('order.status') }}</th>
                    <th>{{ trans('order.created_at') }}</th>
                  </tr>
                  </thead>
                  <tbody>
@if (count($topOrder))
  @foreach ($topOrder as $order)
                    <tr>
                      <td><a href="{{ route('admin_order.detail',['id'=>$order->id]) }}">Order#{{ $order->id }}</a></td>
                      <td>{{ $order->email }}</td>
                      <td><span class="label label-{{ $mapStyleStatus[$order->status]??'' }}">{{ $order->orderStatus->name }}</span></td>
                      <td>{{ $order->created_at }}</td>
                    </tr>
  @endforeach
@endif
                  </tbody>
                </table>
              </div>
            </div>
      </div>
    </div>
  </div>
{{-- //End top order --}}

{{-- Top customer --}}
@php
  $topCustomer = $users->orderBy('id','desc')->limit(10)->get();
@endphp
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('admin.top_customer_new') }}</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>

      <div class="box-body table-responsive no-padding box-primary">
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>{{ trans('customer.id') }}</th>
                    <th>{{ trans('customer.email') }}</th>
                    <th>{{ trans('customer.name') }}</th>
                    <th>{{ trans('customer.created_at') }}</th>
                  </tr>
                  </thead>
                  <tbody>
@if (count($topCustomer))
  @foreach ($topCustomer as $customer)
                    <tr>
                      <td><a href="{{ route('admin_customer.edit',['id'=>$customer->id]) }}">ID#{{ $customer->id }}</a></td>
                      <td>{{ $customer->email }}</td>
                      <td>{{ $customer->name }}</td>
                      <td>{{ $customer->created_at }}</td>
                    </tr>
  @endforeach
@endif
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
      </div>
    </div>
  </div>
  {{-- //End customer --}}
  </div>

@endsection


@push('styles')
@endpush

@push('scripts')
  <script src="{{ asset('admin/plugin/chartjs/dist/Chart.bundle.min.js') }}"></script>
  <script type="text/javascript">



$(document).ready(function($) {
var ctx_month = document.getElementById('chart-days-in-month').getContext('2d');
 new Chart(ctx_month, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        // type: 'category',
        labels: {!! $arrDays !!},
        datasets: [

        {
            label: "Total amount",
            backgroundColor: 'rgba(225,0,0,0.4)',
            borderColor: "rgb(231, 53, 253)",
            borderCapStyle: 'square',
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "yellow",
            pointHoverBorderColor: "brown",
            data: {!! $arrTotalsAmount !!},
            showLine: true, // disable for a single dataset,
            yAxisID: "y-axis-gravity",
            fill: false,
            type: 'line',
            lineTension: 0.1,
        },
        {
            label: "Total order",
            backgroundColor: 'rgb(138, 199, 214)',
            borderColor: 'rgb(138, 199, 214)',
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "brown",
            pointHoverBorderColor: "yellow",
            data: {!! $arrTotalsOrder !!},
            showLine: true, // disable for a single dataset,
            yAxisID: "y-axis-density",
            spanGaps: true,
            lineTension: 0.1,

        },

        ]
    },

    // Configuration options go here
    options: {
        responsive: true,
        legend: {
          display: true,
        },
        layout: {
            padding: {
                left: 10,
                right: 10,
                top: 0,
                bottom: 0
            }
        },
        scales: {
            yAxes: [
            {
              position: "left",
              id: "y-axis-density",
                ticks: {
                    beginAtZero:true,
                    max: {!! $max_order  !!} + 5,
                    min: 0,
                    stepSize: 2,
                },
                  scaleLabel: {
                     display: true,
                     labelString: 'Total order',
                     fontSize: 15,

                  }
            },
            {
              position: "right",
              id: "y-axis-gravity",
              ticks: {
                    beginAtZero:true,
                    callback: function(label, index, labels) {
                        return format_number(label);
                    },
                },
                scaleLabel: {
                     display: true,
                     labelString: 'Total amount (Bit)',
                     fontSize: 15
                  }
            }
            ]
        },

        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';

                    if (label) {
                        label += ': ';
                    }
                    label += format_number(tooltipItem.yLabel);
                    return label;
                }
            }
        }
    }
});
});






    $(document).ready(function($) {
    var ctx_year = document.getElementById('chartjs-1').getContext('2d');
     new Chart(ctx_year, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            "labels":{!! $months1 !!},
            "datasets":[
                {
                    "label":"Total amount",
                    "data":{!! $arrTotalsAmount_year !!},
                    "fill":false,
                    "backgroundColor":[
                    "rgba(191, 25, 232, 0.2)",
                    "rgba(191, 25, 232, 0.2)",
                    "rgba(191, 25, 232, 0.2)",
                    "rgba(191, 25, 232, 0.2)",
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(255, 159, 64, 0.2)",
                    "rgba(255, 205, 86, 0.2)",
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                    "rgba(201, 203, 207, 0.2)",
                    "rgba(181, 147, 50, 0.2)",
                    "rgba(232, 130, 81, 0.2)",
                    ],
                    "borderColor":[
                    "rgb(191, 25, 232)",
                    "rgb(191, 25, 232)",
                    "rgb(191, 25, 232)",
                    "rgb(191, 25, 232)",
                    "rgb(255, 99, 132)",
                    "rgb(255, 159, 64)",
                    "rgb(255, 205, 86)",
                    "rgb(75, 192, 192)",
                    "rgb(54, 162, 235)",
                    "rgb(153, 102, 255)",
                    "rgb(201, 203, 207)",
                    "rgb(181, 147, 50)",
                    "rgb(232, 130, 81)",
                    ],
                    "borderWidth":1,
                    type:"bar",
                },
                {
                    "label":"Line total amount",
                    "data":{!! $arrTotalsAmount_year !!},
                    "fill":false,
                    "backgroundColor":"red",
                    "borderColor":"red",
                    "borderWidth":1,
                    type:"line",
                }
            ]
        },
        options: {
            responsive: true,
            legend: {
              display: true,
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 0,
                    bottom: 0
                }
            },

            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';

                        if (label) {
                            label += ': ';
                        }
                        label += format_number(tooltipItem.yLabel);
                        return label;
                    }
                }
            },
            scales: {
                yAxes: [
                {
                  position: "left",
                  // id: "y-axis-amount",
                  ticks: {
                        beginAtZero:true,
                        callback: function(label, index, labels) {
                            return format_number(label);
                        },
                    },
                    scaleLabel: {
                         display: true,
                         labelString: 'Bit',
                         fontSize: 15
                      }
                }
                ]
            },
        },

    });
    });
  </script>
@endpush
