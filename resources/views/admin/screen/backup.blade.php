@extends('admin.layout')

@section('main')
      <div class="row">
        <div class="col-xs-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body"  id="pjax-container">
              <div><button id="generate" onClick="generateBackup($(this));" class="btn btn-success btn-flat" data-loading-text="{{ trans('backup.processing') }}"><span class="glyphicon glyphicon-plus"></span>{{ trans('backup.generate_now') }}</button></div>
             <table id="main-table" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>{{ trans('backup.sort') }}</th>
                  <th>{{ trans('backup.date') }}</th>
                  <th>{{ trans('backup.name') }}</th>
                  <th>{{ trans('backup.size') }}</th>
                  <th>{{ trans('backup.download') }}</th>
                  <th>{{ trans('backup.remove') }}</th>
                  <th>{{ trans('backup.restore') }}</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($arrFiles as $key => $file)
                    <tr>
                     <td>{{ (count($arrFiles) - $key) }}</td>
                     <td>{{ $file['time']}}</td>
                     <td>{{ $file['name']}}</td>
                     <td>{{ $file['size']}}</td>
                      <td>{!! '<a href="?download='.$file['name'].'"><button title="'.trans('backup.download').'" data-loading-text="'.trans('backup.processing').'" class="btn btn-flat btn-primary"><span class="glyphicon glyphicon-save"></span> '.trans('backup.download').'</button ></a>' !!}</td>
                      <td>{!! '<button  onClick="processBackup($(this),\''.$file['name'].'\',\'remove\');" title="'.trans('backup.remove').'" data-loading-text="'.trans('backup.processing').'" class="btn btn-flat btn-danger"><span class="glyphicon glyphicon-trash"></span> '.trans('backup.remove').'</button >' !!}</td>
                      <td>{!! '<button  onClick="processBackup($(this),\''.$file['name'].'\',\'restore\');" title="'.trans('backup.restore').'" data-loading-text="'.trans('backup.processing').'" class="btn btn-flat btn-warning"><span class="glyphicon glyphicon-retweet"></span> '.trans('backup.restore').'</button >' !!}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    <div>
</div>


@endsection

@push('styles')


@endpush

@push('scripts')
{{-- //Pjax --}}
<script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>

<script type="text/javascript">
  function processBackup(obj,file,action) {
      // var checkstr =  confirm('are you sure you want to do this?');
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, do it!'
      }).then((result) => {
        if (result.value) {
          $('#loading').show()
          obj.button('loading');
          $.ajax({
            type: 'POST',
            dataType:'json',
            url: '{{ route('admin.backup.process') }}',
            data: {
              "_token": "{{ csrf_token() }}",
              "file":file,
              "action":action,
            },
            success: function (response) {
              // console.log(response);
              if(parseInt(response.error) ==0){
                  $.pjax.reload({container:'#pjax-container'});
                  alertJs('success', response.msg);
              }else{
                alertJs('error', response.msg);
              }
              $('#loading').hide();
              obj.button('reset');
            }
          });
        }
      })
  }

  function generateBackup(obj) {
      $('#loading').show()
      obj.button('loading');
      $.ajax({
        type: 'POST',
        dataType:'json',
        url: '{{ route('admin.backup.generate') }}',
        data: {
          "_token": "{{ csrf_token() }}",
        },
        success: function (response) {
          console.log(response);
          if(parseInt(response.error) ==0){
              $.pjax.reload({container:'#pjax-container'});
                Swal.fire(
                'Success!',
                '',
                'success'
                )
          }else{
            Swal.fire(
              response.msg,
              'You clicked the button!',
              'error'
              )
          }
          $('#loading').hide();
          obj.button('reset');
        }
      });

  }

    $(document).ready(function(){
    // does current browser support PJAX
      if ($.support.pjax) {
        $.pjax.defaults.timeout = 2000; // time in milliseconds
      }
    });

</script>


@endpush
