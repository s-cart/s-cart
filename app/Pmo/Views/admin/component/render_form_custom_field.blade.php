@if (isset($customFields) && count($customFields))
                <hr class="kind ">
                <label>{{ sc_language_render('admin.custom_field.title') }} (<a target=_new href="{{ sc_route_admin('admin_custom_field.index') }}"><i class="fa fa-plus" aria-hidden="true"></i></a>)</label>
                    @foreach ($customFields as $keyField => $field)
                    <div class="form-group row kind   {{ $errors->has('fields.'.$field->code) ? ' text-red' : '' }}">
                        <label class="col-sm-2 col-form-label">{{ sc_language_render($field->name) }}</label>
                        <div class="col-sm-8">
                        @php
                            $default  = json_decode($field->default, true);
                            $dataForm = [
                                'name' => ($field->option == 'checkbox') ?'fields['.$field->code.'][]' : 'fields['.$field->code.']',
                                'type' => $field->option,
                                'attribute' => '',
                                'placeholder' => '',
                                'class' => 'input-sm '.$field->code,
                                'id' => $keyField,
                                'default' => old('fields.'.$field->code, ($fields[$field->code]['text'] ?? '')),
                                'dataFormat' => $default,
                                'css' => 'width: 100%;',
                                'required' =>  $field->required,
                            ];
                        @endphp
                        {!! sc_form_render_field($dataForm) !!}

                            @if ($errors->has('fields.'.$field->code))
                            <span class="form-text">
                                <i class="fa fa-info-circle"></i> {{ $errors->first('fields.'.$field->code) }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
@endif