{!! Form::label($name, $display_name ?? __(ucfirst(str_replace('_', ' ', str_replace('_id', '', $name))))) !!}
{!! Form::select($name . ((isset($multiple) && $multiple) ? '[]' : ''), $data, $selected ?? null, ['id' => $name, 'data-model' => $data_model ?? '', 'class' => ['form-control',$class ?? ''], 'multiple' => $multiple ?? false, ] + (isset($placeholder) ? ['placeholder' => $placeholder ?? false] : [])) !!}
{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}


