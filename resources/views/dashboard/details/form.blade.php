
<div class="row">
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._text', (['name' => 'key']))
    </div>
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._checkbox', (['name' => 'is_show', 'checked' => isset($detail) ? $detail->is_show :false,  'text' => [__('dashboard_forms.no'), __('dashboard_forms.yes')]]))
    </div>
</div>


