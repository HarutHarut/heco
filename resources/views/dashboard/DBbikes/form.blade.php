<div>
    <div class="row">
        <div class="col-lg-6 form-group">
            @include('dashboard.components.form._text', (['name' => 'name']))
        </div>
        <div class="col-lg-6 form-group">
            @include('dashboard.components.form._number', (['name' => 'year','min' => 1900, 'max' => date('Y')+1]))
        </div>
    </div>
    <input type="hidden" name="type" value="{{request()->get('type')}}">
    <input type="hidden" name="new_bike" value="{{request()->get('new_bike')}}">
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
                @include('dashboard.components.form._number', (['name' => 'msrp','min' => 0]))
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'brand_id', 'class' => 'bike-brand', 'data' => $brands, 'data_model' => $bike->brand_model_id ?? '', 'selected' => $bike->brand_id ?? null, 'select_2' => false, 'multiple' => false, 'placeholder' => __('dashboard_forms.brands')]))
            </div>

            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'brand_model_id', 'data' => isset($models) ? $models: [], 'selected' => $bike->brand_model_id ?? null, 'select_2' => false, 'multiple' => false , 'placeholder' => __('dashboard_forms.models')]))
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
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
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._number', (['name' => 'weight','min' => 0]))
            </div>
            <div class="col-lg-6 form-group">
                @include('dashboard.components.form._select', (['name' => 'component_id', 'data' => $components, 'selected' => isset($bike) ? $bike->component_id : '', 'select_2' => false, 'multiple' => false, 'placeholder' => __('dashboard_forms.component')]))
            </div>
        </div>

        <div class="sell-1-components">
            <h2>{{__('Components')}}</h2>
            <table class="w-100">
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
                                        <label for="test53{{$item->id.$status}}"></label>
                                    </div>
                                @endforeach

                            </div>
                        </td>
                        <td class="w-25"><span>{{__($item->key)}}</span>
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
        </div>

</div>


