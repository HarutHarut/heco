<div class="kt-portlet__body border-12">
    <div class="row">
        <div class="col-lg-6 form-group">
            @include('dashboard.components.form._select', (['name' => 'slug', 'data' => \App\Models\Page::PAGES, 'selected' => isset($page) ? $page->slug : null, 'select_2' => false, 'multiple' => false, 'placeholder' => __('dashboard_forms.pages')]))
        </div>

    </div>
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
                            @include('dashboard.components.form._text', (['name' =>"title[$localeCode]" , 'value' => isset($page) ? $transData[$localeCode]->title ?? '' : '', 'error_name' => "title.*"]))
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            @include('dashboard.components.form._textarea', (['name' => "short_description[$localeCode]", 'editor' => false, 'value' => isset($page) ? $transData[$localeCode]->short_description ?? '' : '', 'error_name' => "short_description.*"]))
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            @include('dashboard.components.form._textarea', (['name' => "description[$localeCode]", 'editor' => true, 'value' => isset($page) ? $transData[$localeCode]->description ?? '' : '', 'error_name' => "description.*"]))
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
