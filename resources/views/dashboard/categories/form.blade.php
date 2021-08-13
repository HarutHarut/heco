

<div class="row">
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._text', (['name' => 'name']))
    </div>
</div>

<div class="row">
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._checkbox', (['name' => 'status', 'checked' => isset($category) ? $category->status :false,  'text' => [__('dashboard_forms.inactive'), __('dashboard_forms.active')]]))
    </div>
</div>


