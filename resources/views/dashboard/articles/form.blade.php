<div class="kt-portlet__body border-12">

    <div class="kt-portlet__body border-12">
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
                        <div class="col-lg-6 form-group">
                            @include('dashboard.components.form._text', (['name' =>"title[$localeCode]" , 'value' => isset($article) ? $transData[$localeCode]->title ?? '' : '', 'error_name' => "title.*"]))
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            @include('dashboard.components.form._textarea', (['name' => "short_description[$localeCode]", 'editor' => false, 'value' => isset($article) ? $transData[$localeCode]->short_description ?? '' : '', 'error_name' => "short_description.$localeCode"]))
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            @include('dashboard.components.form._textarea', (['name' => "description[$localeCode]", 'editor' => true, 'value' => isset($article) ? $transData[$localeCode]->description ?? '' : '', 'error_name' => "description.$localeCode"]))
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <div>
                    <label for="">{{__('dashboard_forms.image')}}</label>
                    <input type="file" class="demo custom-file-img" name="image" value="{{ isset($article) ? $article->image ?? '' : '' }}"
                           data-jpreview-container="#demo-5-container">
                </div>
                <div id="demo-5-container" class="jpreview-container">
                    @if(isset($article))
                        <div class="jpreview-image"
                             style="background-image: url({{$article->imageThumb(400)}})"></div>
                    @else
                        <div class="jpreview-image d-none" style="background-image: url()"></div>
                    @endif
                </div>
                {!! $errors->first('image', '<span class="form-text text-danger">:message</span>') !!}
            </div>

            @include('dashboard.components.form._checkbox', (['name' => 'status', 'checked' => isset($article) ? $article->status :false,  'text' => [__('dashboard_forms.inactive'), __('dashboard_forms.active')]]))
        </div>
    </div>
</div>
