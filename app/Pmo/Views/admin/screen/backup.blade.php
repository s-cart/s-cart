@extends($templatePathAdmin.'layout')

@section('main')
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body"  id="pjax-container">

              <div class="btn-group">
                <button type="button" class="btn btn-default btn-flat"><i class="fa fa-save"></i> Backup</button>
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown" data-loading-text="{{ sc_language_render('admin.backup.processing') }}">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu keep-open" role="menu">
                  <li style="height: 200px; overflow:auto; padding:10px;">
                    <table>
                      <tr><th></th><th>Table</th><th>Rows</th><th>Size</th></tr>
                      @foreach ($tableInfo as $table)
                      <tr>
                        <td class="checkbox icheck">
                            <input type="checkbox"  class="column-select-item table-process" data-id="{{ $table->table_name }}" checked/>
                        </td>
                        <td>
                          {{ $table->table_name }}
                        </td>
                        <td>
                          {{ $table->table_rows }}
                        </td>
                        <td>
                          {{ number_format($table->data_length/1048576, 4) }}MB
                        </td>
                      </tr>
                    @endforeach
                    </table>
                  </li>
                  <li class="divider" style="border-top: 1px solid #eaeae1; padding-bottom: 5px;">
                  </li>
                  <li>
                      &nbsp;<input id="file-name" value="" placeholder="File name">.sql
                      <div class="float-right">
                        <button class="btn btn-sm btn-default column-un-select-all">X</button>&nbsp;
                        <button class="btn btn-sm btn-default column-select-all">All</button>&nbsp;
                        <button class="btn btn-sm btn-success column-select-submit" onClick="generateBackup($(this));" id="generate">Submit</button>
                      </div>

                  </li>
              </ul>
              </div>

              <div class="table-responsive">
              <table id="main-table" class="table table-hover box-body text-wrap table-bordered">
                <thead>
                <tr>
                  <th>{{ sc_language_render('admin.backup.sort') }}</th>
                  <th>{{ sc_language_render('admin.backup.date') }}</th>
                  <th>{{ sc_language_render('admin.backup.name') }}</th>
                  <th>{{ sc_language_render('admin.backup.size') }}</th>
                  <th>{{ sc_language_render('admin.backup.download') }}</th>
                  <th>{{ sc_language_render('admin.backup.remove') }}</th>
                  <th>{{ sc_language_render('admin.backup.restore') }}</th>
                </tr>
                </thead>
                <tbody>
                  @php
                      $sort = count($arrFiles)
                  @endphp
                  @foreach ($arrFiles as $file)
                    <tr>
                     <td>{{($sort--) }}</td>
                     <td>{{ $file['time']}}</td>
                     <td>{{ $file['name']}}</td>
                     <td>{{ $file['size']}}</td>
                      <td>{!! '<a href="?download='.$file['name'].'"><button title="'.sc_language_render('admin.backup.download').'" data-loading-text="'.sc_language_render('admin.backup.processing').'" class="btn btn-flat btn-primary"><i class="fas fa-download"></i> '.sc_language_render('admin.backup.download').'</button ></a>' !!}</td>
                      <td>{!! '<button  onClick="processBackup($(this),\''.$file['name'].'\',\'remove\');" title="'.sc_language_render('admin.backup.remove').'" data-loading-text="'.sc_language_render('admin.backup.processing').'" class="btn btn-flat btn-danger"><span class="glyphicon glyphicon-trash"></span> '.sc_language_render('admin.backup.remove').'</button >' !!}</td>
                      <td>{!! '<button  onClick="processBackup($(this),\''.$file['name'].'\',\'restore\');" title="'.sc_language_render('admin.backup.restore').'" data-loading-text="'.sc_language_render('admin.backup.processing').'" class="btn btn-flat btn-warning"><span class="glyphicon glyphicon-retweet"></span> '.sc_language_render('admin.backup.restore').'</button >' !!}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              </div>
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

<script type="text/javascript">
  function processBackup(obj,file,action) {
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
            url: '{{ sc_route_admin('admin.backup.process') }}',
            data: {
              "_token": "{{ csrf_token() }}",
              "file":file,
              "action":action,
            },
            success: function (response) {
              // console.log(response);
              if(parseInt(response.error) ==0){
                  alertJs('success', response.msg);
                  location.reload();
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
      var selected = [];
      $('.table-process:checked').each(function(){
          selected.push($(this).data('id'));
      });
      var includeTables = selected.join();

      $.ajax({
        type: 'POST',
        dataType:'json',
        url: '{{ sc_route_admin('admin.backup.generate') }}',
        data: {
          "_token": "{{ csrf_token() }}",
          "includeTables": includeTables,
          "fileName": $('#file-name').val(),
        },
        success: function (response) {
          if(parseInt(response.error) ==0){
                Swal.fire(
                'Success!',
                '',
                'success'
                );
                location.reload();
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

    $('.column-select-all').on('click', function () {
      $('.column-select-item').iCheck('check');
      return false;
    });

    $('.column-un-select-all').on('click', function () {
      $('.column-select-item').iCheck('uncheck');
      return false;
    });

</script>


@endpush
