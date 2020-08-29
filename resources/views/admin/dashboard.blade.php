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
        <!-- /.row -->


        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">{{ trans('admin.order_month') }}</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div id="chart-days" style="width:100%; height:auto;"></div>
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->


        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">{{ trans('admin.order_year') }}</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div id="chart-pie" style="width:100%; height:auto;"></div>
                  </div>
                  <div class="col-md-8">
                    <div id="chart-month" style="width:100%; height:auto;"></div>
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->


        <!-- Main row -->
        <div class="row">

          <!-- Left col -->
          <div class="col-md-6">
            @php
            $topOrder = $orders->with('orderStatus')->orderBy('id','desc')->limit(10)->get();
            @endphp
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">{{ trans('admin.top_order_new') }}</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
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
                              <td><span class="badge badge-{{ $mapStyleStatus[$order->status]??'' }}">{{ $order->orderStatus->name }}</span></td>
                              <td>{{ $order->created_at }}</td>
                            </tr>
                      @endforeach
                    @endif
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <!-- Left col -->
          <div class="col-md-6">
            @php
            $topCustomer = $users->orderBy('id','desc')->limit(10)->get();
            @endphp
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">{{ trans('admin.top_customer_new') }}</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <tr>
                      <th>{{ trans('customer.id') }}</th>
                      <th>{{ trans('customer.email') }}</th>
                      <th>{{ trans('customer.name') }}</th>
                      <th>{{ trans('customer.created_at') }}</th>
                    </tr>
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
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->


          </div>
          <!-- /.col -->


        </div>
        <!-- /.row -->
@endsection


@push('styles')
@endpush

@push('scripts')
  <script src="{{ asset('admin/plugin/chartjs/highcharts.js') }}"></script>
  <script src="{{ asset('admin/plugin/chartjs/highcharts-3d.js') }}"></script>
  <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function () {
      var myChart = Highcharts.chart('chart-days', {
          credits: {
              enabled: false
          },
          title: {
              text: '{{ trans('chart.static_30_day') }}'
          },
          xAxis: {
              categories: {!! json_encode(array_keys($orderInMonth)) !!},
              crosshair: false

          },

          yAxis: [{
              min: 0,
              title: {
                  text: '{{ trans('chart.order') }}'
              },
          }, {
              title: {
                  text: '{{ trans('chart.amount') }}'
              },
              opposite: true
          },
          ],

          legend: {
                align: 'left',
                verticalAlign: 'top',
                borderWidth: 0
            },

          tooltip: {
              headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
              pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
            column: {
                      pointPadding: 0.2,
                      borderWidth: 0
                  },
          },

          series: [
          {
              type: 'column',
              name: '{{ trans('chart.order') }}',
              data: {!! json_encode(array_values($orderInMonth)) !!},
              dataLabels: {
                  enabled: true,
                  format: '{point.y:.0f}'
              }
          },
          {
              type: 'spline',
              name: '{{ trans('chart.amount') }}',
              color: '#32ca0c',
              yAxis: 1,
              data: {!! json_encode(array_values($amountInMonth)) !!},
              borderWidth: 0,
              dataLabels: {
                  enabled: true,
                  borderRadius: 3,
                  backgroundColor: 'rgba(252, 255, 197, 0.7)',
                  borderWidth: 0.5,
                  borderColor: '#AAA',
                  y: -6
              }
          },
        ]
      });
  });



// Set up the chart
var chart = new Highcharts.Chart({
    chart: {
        renderTo: 'chart-month',
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 0,
            beta: 10,
            depth: 50,
            viewDistance: 25
        }
    },
    title: {
        text: '{{ trans('chart.static_month') }}'
    },
    subtitle: {
        text: '{{ trans('chart.static_month_help') }}'
    },
    legend: {
            enabled: false,
      },
    credits: {
              enabled: false
          },
    xAxis: {
        categories: {!! json_encode(array_keys($dataInYear)) !!},
        crosshair: false,
    },
    yAxis: [
            {
                min: 0,
                title: {
                    text: '{{ trans('chart.amount') }}'
                },
            }
          ],
    plotOptions: {
        column: {
            depth: 25
        },
        series: {
            dataLabels: {
                enabled: true,
                borderRadius: 3,
                backgroundColor: 'rgba(252, 255, 197, 0.7)',
                borderWidth: 0.5,
                borderColor: '#AAA',
                y: -6
            }
        }
    },
    series: [
      {
        name : '{{ trans('chart.amount') }}',
        data: {!! json_encode(array_values($dataInYear)) !!},
      },
      {
          type : 'spline',
          color: '#d05135',
          name : '{{ trans('chart.amount') }}',
          data: {!! json_encode(array_values($dataInYear)) !!}
      }
  ]
});

function showValues() {
    $('#alpha-value').html(chart.options.chart.options3d.alpha);
    $('#beta-value').html(chart.options.chart.options3d.beta);
    $('#depth-value').html(chart.options.chart.options3d.depth);
}

// Activate the sliders
$('#sliders input').on('input change', function () {
    chart.options.chart.options3d[this.id] = parseFloat(this.value);
    showValues();
    chart.redraw(false);
});

showValues();
</script>

<script>
  Highcharts.chart('chart-pie', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    credits: {
              enabled: false
          },
    title: {
        text: '{{ trans('chart.static_country') }}'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}:{point.y}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: '{{ trans('chart.country') }}',
        data: {!! $dataPie !!},
    }]
});
</script>

@endpush
