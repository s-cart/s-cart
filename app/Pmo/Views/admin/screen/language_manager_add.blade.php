@extends($templatePathAdmin.'layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{!! $title!!}</h3>
            </div>

                <div class="box-body">
                    <div class="fields-group">
                        <form action="{{ sc_route_admin('admin_language_manager.add') }}" method="POST">
                            @csrf
                            <table class="table table-hover box-body text-wrap table-bordered">
                              <tr>
                                  <td>{{ sc_language_render('admin.language_manager.select_position') }}</td>
                                  <td>{{ sc_language_render('admin.language_manager.code') }}</td>
                                  <td>{{ sc_language_render('admin.language_manager.text') }}</td>
                              </tr>
                              <tr class="form-add-new">
                                <td class="{{ ($errors->has('position') || $errors->has('position_new')) ? 'text-red':'' }}">
                                      <select class="form-control select-position select2" name="position">
                                        <option value="">{{ sc_language_render('admin.language_manager.select_position') }}</option>
                                        @foreach ($positionLang as $itemPosition)
                                            <option value="{{ $itemPosition }}"  {{ (old('position') == $itemPosition) ? 'selected':'' }} >{{ $itemPosition }}</option>
                                        @endforeach
                                      </select>
                                        {{ sc_language_render('admin.language_manager.new_position') }}:
                                      @if ($errors->has('position'))
                                      <span class="form-text">
                                          <i class="fa fa-info-circle"></i>
                                          {{ $errors->first('position') }}
                                      </span>
                                      @endif

                                      <input name="position_new" value="{{ old('position_new') }}" class="form-control" placeholder="{{ sc_language_render('admin.language_manager.position') }}">
                                      @if ($errors->has('position_new'))
                                      <span class="form-text">
                                          <i class="fa fa-info-circle"></i>
                                          {{ $errors->first('position_new') }}
                                      </span>
                                      @endif
                                </td>
                                <td class="{{ $errors->has('code') ? 'text-red':'' }}">
                                    <input name="code" value="{{ old('code') }}" placeholder="New code" class="form-control">
                                    @if ($errors->has('code'))
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i>
                                        {{ $errors->first('code') }}
                                    </span>
                                    @endif
                                </td>
                                <td class="{{ $errors->has('text') ? 'text-red':'' }}">
                                    <textarea name="text" placeholder="Value" class="form-control">{{ old('text') }}</textarea>
                                    @if ($errors->has('text'))
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i>
                                        {{ $errors->first('text') }}
                                    </span>
                                    @endif
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i>
                                        {!! sc_language_render('admin.language_manager.text_help',['link' => sc_route_admin('admin_language_manager.index')]) !!}
                                    </span>
                                </td>
                              </tr>
                              <tr id="save-language">
                                <td colspan="4">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i></button>
                                    </div>
                                </td>
                            </tr>
                            </table>
                            </form>
                        
                    </div>
                </div>

                <!-- /.box-footer -->
        </div>
    </div>
</div>


@endsection

@push('styles')
@endpush

@push('scripts')
@endpush