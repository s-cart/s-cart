@extends($templatePathAdmin.'layout')



@section('main')
        <div class="row">

          @if (config('admin.admin_dashboard.total_order'))
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">{{ sc_language_render('admin.dashboard.total_order') }}</span>
                <span class="info-box-number">{{ number_format($totalOrder) }}</span>
                <a href="{{ sc_route_admin('admin_order.index') }}" class="small-box-footer">
                  {{ sc_language_render('action.view_more') }}&nbsp;
                  <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          @endif

          @if (config('admin.admin_dashboard.total_product'))
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-aqua"><i class="fa fa-tags"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">{{ sc_language_render('admin.dashboard.total_product') }}</span>
                <span class="info-box-number">{{ number_format($totalProduct) }}</span>
                <a href="{{ sc_route_admin('admin_product.index') }}" class="small-box-footer">
                    {{ sc_language_render('action.view_more') }}&nbsp;
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
  
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          @endif
  
          @if (config('admin.admin_dashboard.total_customer'))
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">{{ sc_language_render('admin.dashboard.total_customer') }}</span>
                <span class="info-box-number">{{ number_format($totalCustomer) }}</span>
                <a href="{{ sc_route_admin('admin_customer.index') }}" class="small-box-footer">
                    {{ sc_language_render('action.view_more') }}&nbsp;
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          @endif
  
          @if (config('admin.admin_dashboard.total_blog'))
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
              <span class="info-box-icon bg-red"><i class="fa fa-map-signs"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">{{ sc_language_render('admin.dashboard.total_blog') }}</span>
                <span class="info-box-number">{{ number_format($totalNews) }}</span>
                <a href="{{ sc_route_admin('admin_news.index') }}" class="small-box-footer">
                    {{ sc_language_render('action.view_more') }}&nbsp;
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          @endif
        </div>
        <!-- /.row -->

        @if (config('admin.admin_dashboard.order_month'))
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">{{ sc_language_render('admin.dashboard.order_month') }}</h5>

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
        @endif
        <!-- /.row -->


        @if (config('admin.admin_dashboard.order_year') || config('admin.admin_dashboard.pie_chart'))
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">{{ sc_language_render('admin.dashboard.order_year') }}</h5>

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

                  @if (config('admin.admin_dashboard.pie_chart'))
                  <div class="{{ config('admin.admin_dashboard.order_year') ? 'col-md-4' : 'col-md-12'  }}">
                    <div id="chart-pie" style="width:100%; height:auto;"></div>
                  </div>
                  @endif

                  @if (config('admin.admin_dashboard.order_year'))
                  <div class="{{ config('admin.admin_dashboard.pie_chart') ? 'col-md-8' : 'col-md-12'  }}">
                    <div id="chart-month" style="width:100%; height:auto;"></div>
                  </div>
                  @endif
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        @endif
        <!-- /.row -->

        @if (config('admin.admin_dashboard.top_order_new') || config('admin.admin_dashboard.top_customer_new'))
        <!-- Main row -->
        <div class="row">

          @if (config('admin.admin_dashboard.top_order_new'))
                        <!-- Left col -->
          <div class="{{ config('admin.admin_dashboard.top_customer_new') ? 'col-md-6' : 'col-md-12' }}">
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">{{ sc_language_render('admin.dashboard.top_order_new') }}</h3>

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
                        <th>ID</th>
                        <th>{{ sc_language_render('order.email') }}</th>
                        <th>{{ sc_language_render('order.status') }}</th>
                        <th>{{ sc_language_render('admin.created_at') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if (count($topOrder))
                      @foreach ($topOrder as $order)
                            <tr>
                              <td><a href="{{ route('admin_order.detail',['id'=>$order->id]) }}">#{{ $order->id }}</a></td>
                              <td>{{ $order->email }}</td>
                              <td><span class="badge badge-{{ $mapStyleStatus[$order->status]??'' }}">{{ $order->orderStatus ? $order->orderStatus->name : $order->status }}</span></td>
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
          @endif

          @if (config('admin.admin_dashboard.top_customer_new'))         
          <!-- Left col -->
          <div class="{{ config('admin.admin_dashboard.top_order_new') ? 'col-md-6' : 'col-md-12' }}">
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">{{ sc_language_render('admin.dashboard.top_customer_new') }}</h3>

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
                      <th>{{ sc_language_render('customer.email') }}</th>
                      <th>{{ sc_language_render('customer.name') }}</th>
                      <th>{{ sc_language_render('customer.admin.provider') }}</th>
                      <th>{{ sc_language_render('admin.created_at') }}</th>
                    </tr>
                    <tbody>
                      @if (count($topCustomer))
                      @foreach ($topCustomer as $customer)
                        <tr>
                          <td><a href="{{ sc_route_admin('admin_customer.edit',['id'=>$customer->id]) }}">{{ $customer->email }}</a></td>
                          <td>{{ $customer->name }}</td>
                          <td>{{ $customer->provider }}</td>
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
          @endif
          <!-- /.col -->


        </div>
        @endif
        <!-- /.row -->
@endsection


@push('styles')
@endpush

@push('scripts')
  <script src="{{ sc_file('admin/plugin/chartjs/highcharts.js') }}"></script>
  <script src="{{ sc_file('admin/plugin/chartjs/highcharts-3d.js') }}"></script>
  <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function () {
      var myChart = Highcharts.chart('chart-days', {
          credits: {
              enabled: false
          },
          title: {
              text: '{{ sc_language_render('admin.chart.static_30_day') }}'
          },
          xAxis: {
              categories: {!! json_encode(array_keys($orderInMonth)) !!},
              crosshair: false

          },

          yAxis: [{
              min: 0,
              title: {
                  text: '{{ sc_language_render('admin.chart.order') }}'
              },
          }, {
              title: {
                  text: '{{ sc_language_render('admin.chart.amount') }}'
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
              name: '{{ sc_language_render('admin.chart.order') }}',
              data: {!! json_encode(array_values($orderInMonth)) !!},
              dataLabels: {
                  enabled: true,
                  format: '{point.y:.0f}'
              }
          },
          {
              type: 'line',
              name: '{{ sc_language_render('admin.chart.amount') }}',
              color: '#c7730c',
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
        text: '{{ sc_language_render('admin.chart.static_month') }}'
    },
    subtitle: {
        text: '{{ sc_language_render('admin.chart.static_month_help') }}'
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
                    text: '{{ sc_language_render('admin.chart.amount') }}'
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
        name : '{{ sc_language_render('admin.chart.amount') }}',
        data: {!! json_encode(array_values($dataInYear)) !!},
      },
      {
          type : 'line',
          color: '#d05135',
          name : '{{ sc_language_render('admin.chart.amount') }}',
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
        text: '{{ $pieChartTitle ?? '' }}'
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
        name: '{{ sc_language_render('admin.chart.device') }}',
        data: {!! $dataPie !!},
    }]
});
</script>

@endpush
