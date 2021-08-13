<div class="row">
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._text', (['name' => 'name']))
    </div>
</div>

<div class="row">
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._select', (['name' => 'brand_id', 'data' => $brands, 'selected' => isset($model) ? $model->brand_id : 0, 'select_2' => false, 'multiple' => false]))
    </div>
</div>

