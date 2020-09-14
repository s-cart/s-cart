<div class="row">

  <div class="col-md-6">

    <div class="card">
      <div class="card-body table-responsivep-0 card-primary">
       <table class="table table-hover">
         <tbody>
           @foreach ($orderConfig as $config)
             <tr>
               <td>{{ sc_language_render($config->detail) }}</td>
               <td><input  type="checkbox" name="{{ $config->key }}"  {{ $config->value?"checked":"" }}></td>
             </tr>
           @endforeach
         </tbody>
       </table>
      </div>
    </div>
  </div>


</div>