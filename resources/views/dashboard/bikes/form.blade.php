<div>
    <div class="row">
        <div class="col-lg-6 form-group">
            @include('dashboard.components.form._text', (['name' => 'name']))
        </div>
        <div class="col-lg-6 form-group">
            @include('dashboard.components.form._number', (['name' => 'year','min' => 1900, 'max' => date('Y')+1]))
        </div>
    </div>

    <div>
        <ul class="nav nav-tabs  nav-tabs-line mb-4" role="tablist">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li class="nav-item">
                    <a class="nav-link @if($loop->first) active @endif @if($errors->has("*_$localeCode")) invalid-area @endif  "
                       data-toggle="tab" href="#kt_tabs_{{$localeCode}}" role="tab">{{$properties['name']}}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <div class="tab-pane @if($loop->first) active @endif" id="kt_tabs_{{$localeCode}}" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                @include('dashboard.components.form._textarea', (['name' => "description[$localeCode]", 'editor' => false, 'value' => isset($bike) ? $bike['description'][$localeCode] ?? '' : '','error_name' => "description.$localeCode"]))
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 form-group">
            @include('dashboard.components.form._textarea', (['name' => 'info']))
        </div>
    </div>

    @if(!request()->type)

        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._number', (['name' => 'msrp','min' => 0]))
            </div>

            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._number', (['name' => 'price','min' => 0]))
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'brand_id', 'class' => 'bike-brand', 'data' => $brands, 'data_model' => $bike->brand_model_id ?? '', 'selected' => isset($bike) ? $bike->brand_id : null, 'select_2' => false, 'multiple' => false, 'placeholder' => __('dashboard_forms.brands')]))
            </div>

            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'brand_model_id', 'data' => isset($models) ? $models: [], 'selected' => $bike->brand_model_id ?? null, 'select_2' => false, 'multiple' => false , 'placeholder' => __('dashboard_forms.models')]))
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 form-group">
                @include('dashboard.components.form._select', (['name' => 'category_ids', 'data' => $categories ,'selected' => isset($bike) ? $bike->category : null,'class' => 'select2-container', 'select_2' => true, 'multiple' => true]))
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._number', (['name' => 'msrp','min' => 0]))
            </div>
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'category_ids', 'data' => $categories ,'selected' => isset($bike) ? $bike->category : null,'class' => 'select2-container', 'select_2' => true, 'multiple' => true]))
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'brand_id', 'class' => 'bike-brand', 'data' => $brands, 'data_model' => $bike->brand_model_id ?? '', 'selected' =>  $bike->brand_id ?? null, 'select_2' => false, 'multiple' => false, 'placeholder' => __('dashboard_forms.brands')]))
            </div>

            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'brand_model_id', 'data' => isset($models) ? $models: [], 'selected' => $bike->brand_model_id ?? null, 'select_2' => false, 'multiple' => false , 'placeholder' => __('dashboard_forms.brands')]))
            </div>
        </div>


    @endif
    @if(!request()->type || request()->type == 'approved')
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <div>
                        <label for="">{{__('dashboard_forms.image_side')}}</label>
                        <input type="file" class="demo custom-file-img" name="side"
                               data-jpreview-container="#demo-2-container">
                    </div>
                    <div id="demo-2-container" class="jpreview-container">
                        @if(isset($bike) && $bike->image('side'))
                            <div class="jpreview-image "
                                 style="background-image: url({{$bike->image('side')}})"></div>
                        @else
                            <div class="jpreview-image d-none" style="background-image: url()"></div>
                        @endif
                    </div>
                    {!! $errors->first('side', '<span class="form-text text-danger">:message</span>') !!}
                </div>
                <div class="form-group">
                    <div>
                        <label for="">{{__('dashboard_forms.image_top')}}</label>
                        <input type="file" class="demo custom-file-img" name="top"
                               data-jpreview-container="#demo-1-container">
                    </div>
                    <div id="demo-1-container" class="jpreview-container">
                        @if(isset($bike) && $bike->image('top'))
                            <div class="jpreview-image "
                                 style="background-image: url({{$bike->image('top')}})"></div>
                        @else
                            <div class="jpreview-image d-none" style="background-image: url()"></div>
                        @endif
                    </div>
                    {!! $errors->first('top', '<span class="form-text text-danger">:message</span>') !!}
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <div>
                        <label for="">{{__('dashboard_forms.image_crank')}}</label>
                        <input type="file" class="demo custom-file-img" name="crank"
                               data-jpreview-container="#demo-3-container">
                    </div>
                    <div id="demo-3-container" class="jpreview-container">
                        @if(isset($bike) && $bike->image('crank'))
                            <div class="jpreview-image"
                                 style="background-image: url({{$bike->image('crank')}})"></div>
                        @else
                            <div class="jpreview-image d-none" style="background-image: url()"></div>
                        @endif
                    </div>
                    {!! $errors->first('crank', '<span class="form-text text-danger">:message</span>') !!}
                </div>
                <div class="form-group">
                    <div>
                        <label for="">{{__('dashboard_forms.image_defects')}}</label>
                        <input type="file" class="demo custom-file-img" name="defects[]" multiple
                               data-jpreview-container="#demo-4-container">
                    </div>
                    <div id="demo-4-container" class="jpreview-container">
                        @if(isset($bike))

                            @foreach($bike->defectImage('defects') as $defects)
                                <div class="jpreview-image" style="background-image: url(/storage/{{$defects}})"></div>
                            @endforeach
                        @else
                            <div class="jpreview-image d-none" style="background-image: url()"></div>
                        @endif
                    </div>
                    {!! $errors->first('defects.*', '<span class="form-text text-danger">:message</span>') !!}
                </div>
            </div>
        </div>
    @endif
    @if(!request()->type)
        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._checkbox', (['name' => 'status', 'value' => 'active', 'checked' => isset($bike) ? ($bike->status == 'active') : false,  'text' => [__('dashboard_forms.inactive'), __('dashboard_forms.active')]]))
            </div>
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._checkbox', (['name' => 'shipping', 'checked' => isset($bike) ? $bike->shipping :false,  'text' => [__('dashboard_forms.shipping_no'), __('dashboard_forms.shipping_yes')]]))
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._checkbox', (['name' => 'preowned', 'checked' => isset($bike) ? $bike->preowned :false,  'text' => [__('dashboard_forms.no'), __('dashboard_forms.yes')]]))
            </div>
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._checkbox', (['name' => 'bargain', 'checked' => isset($bike) ? $bike->bargain :false,  'text' => [__('dashboard_forms.bargain_no'), __('dashboard_forms.bargain_yes')]]))
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._number', (['name' => 'frame_size','min'=>48, 'max'=>62]))
            </div>
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._number', (['name' => 'weight','min' => 0]))
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'condition', 'data' => config('enums.CONDITION'), 'selected' => isset($bike) ? $bike->condition : '', 'select_2' => false, 'multiple' => false ,'placeholder' => __('dashboard_forms.condition')]))
            </div>
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'milage', 'data' => config('enums.MILAGE'), 'selected' => isset($bike) ? $bike->milage : '', 'select_2' => false, 'multiple' => false ,'placeholder' => __('dashboard_forms.milage')]))
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'last_service', 'data' => config('enums.SERVICE'), 'selected' => isset($bike) ? $bike->last_service : '', 'select_2' => false, 'multiple' => false ,'placeholder' => __('dashboard_forms.last_service')]))
            </div>
            <div class="col-lg-6 form-group">
                <label for="pickcolor">{{__('dashboard_forms.color')}}</label>
                <div class="color-wrapper">
                    <input type="text" name="" placeholder="{{__('Color')}}" id="pickcolor"
                           value="" class="form-control call-picker" aria-label="{{__('Color')}}" readonly>
                    <input id="hidden_color" type="hidden" name="color"
                           value="{{isset($bike) ? $bike->color : '#000' }}">
                    <div style="background-color: {{ old('color', isset($bike) ? $bike->color : '#000') }}"
                         class="color-holder call-picker"></div>
                    <div class="color-picker" id="color-picker" style="display: none"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._text', (['name' => 'city', 'id' => 'search-address' ]))
            </div>
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'component_id', 'data' => $components, 'selected' => isset($bike) ? $bike->component_id : '', 'select_2' => false, 'multiple' => false, 'placeholder' => __('dashboard_forms.component')]))
            </div>
        </div>


    @endif
    @if(request()->type)
        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'component_id', 'data' => $components, 'selected' => isset($bike) ? $bike->component_id : '', 'select_2' => false, 'multiple' => false, 'placeholder' => __('dashboard_forms.component')]))
            </div>
        </div>
    @endif
    @if(!request()->type || request()->type == 'approved')

        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['display_name' => 'Shifters', 'name' => 'detail[21][value]', 'data' => $shifters, 'selected' => isset($bike) ? $bike->bike_settings()->where('detail_id', 21)->pluck('value') : '', 'select_2' => false, 'multiple' => false, 'placeholder' => __('dashboard_forms.shifters')]))
            </div>
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['display_name' => 'Brake Types', 'name' => 'detail[4][value]', 'data' => $brake_types, 'selected' => isset($bike) ? $bike->bike_settings()->where('detail_id', 4)->pluck('value') : '', 'select_2' => false, 'multiple' => false, 'placeholder' => __('dashboard_forms.brake_types')]))
            </div>
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['display_name' => 'Frame Material', 'name' => 'detail[1][value]', 'data' => $frame_materials, 'selected' => isset($bike) ? $bike->bike_settings()->where('detail_id', 1)->pluck('value') : '', 'select_2' => false, 'multiple' => false, 'placeholder' => __('dashboard_forms.frame_materials')]))
            </div>

            <div class="col-lg-6 form-group">
                {!! Form::label('availability', __(ucfirst(str_replace('_', ' ', 'availability')))) !!}
                <input type="date" name="availability" id="availability" class="form-control date"
                       placeholder="{{__(ucfirst(str_replace('_', ' ', 'availability')))}}"
                       value="{{old('availability')}}" min="{{\Carbon\Carbon::now()->format('d.m.Y')}}">
                {!! $errors->first('availability', '<span class="form-text text-danger">:message</span>') !!}
            </div>
        </div>

        <div class="sell-1-components">
            <h2>{{__('Components')}}<br>
                <span>{{__('Click on a component to change it or to report it broken / exchanged')}}</span>
            </h2>
            <table>
                @foreach($details as $item)
                    <tr>
                        <td>
                            <div class="d-flex custom-radio-block">
                                @php
                                    $detail_status = 0;
                                    if(isset($bike)){
                                        $detail_id = 0;
                                        if (in_array($item->id, $bike->bike_settings->pluck('detail_id')->toArray())){
                                            $detail_id = $item->id;
                                        }

                                        if ($detail_id){
                                              $detail_status = $bike->bike_settings()->where('detail_id', $detail_id)->first()->status;
                                        }
                                    }

                                @endphp

                                @foreach(\App\Models\Detail::DETAIL_STATUS as $status => $class)

                                    <div class="{{ $class }}">
                                        <input type="radio" id="test53{{$item->id.$status}}"
                                               name="detail[{{$item->id}}][status]"
                                               class="custom-radio"
                                               value="{{$status}}"

                                               @php
                                                   $old = old("detail.$item->id.status");
                                               @endphp
                                               @if($old == $status && !is_null($old))
                                               checked
                                               @endif
                                               @if(is_null($old))
                                               @if($detail_status == $status)
                                               checked
                                            @endif
                                            @endif
                                        >
                                        <label for="test53{{$item->id.$status}}"></label>
                                    </div>
                                @endforeach

                            </div>
                        </td>
                        <td><span>{{__($item->key)}}</span>
                        </td>
                        <td class="toggle">
                            @php
                                $value = '';
                                if (isset($bike)){
                                    $detail = $bike->bike_settings()->where('detail_id', $item->id)->first();
                                    if ($detail){
                                        if ($detail->status == \App\Models\Bike::STATUS_DETAIL_CHANGED){
                                            $value = $detail->note;
                                        }else{
                                            $value = $detail->value;
                                        }
                                    }
                                }
                            @endphp
                            <input name="detail[{{$item->id}}][value]"
                                   value=" {{old("detail.$item->id.value") ??  $value }}" id="details{{$item->id}}"
                                   type="text"
                                   class="form-control input_{{$item->id}}">

                        </td>
                    </tr>
                @endforeach

            </table>

            <div class="component-info">
                <div><span class="circle circle-grey"></span> {{__('default parts')}}</div>
                <div><span class="circle circle-green"></span> {{__('Replaced parts')}}</div>
                <div><span class="circle circle-yellow"></span> {{__('Changed parts')}}</div>
                <div><span class="circle circle-red"></span> {{__('Broken parts')}}</div>
            </div>
        </div>
    @endif



</div>


