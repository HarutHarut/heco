<div class="row">
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._text', (['name' => 'first_name']))
    </div>
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._text', (['name' => 'last_name']))
    </div>
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._email', (['name' => 'email']))
    </div>
</div>
<div class="row">
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._number', (['name' => 'phone']))
    </div>
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._text', (['name' => 'zip']))
    </div>
</div>
<div class="row">
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._text', (['name' => 'country']))
    </div>
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._text', (['name' => 'city']))
    </div>
</div>
<div class="row">
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._text', (['name' => 'street']))
    </div>
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._text', (['name' => 'house_number']))
    </div>
</div>
<div class="row">
    <div class="col-lg-6 form-group">
        @include('dashboard.components.form._checkbox', (['name' => 'status', 'checked' => isset($user) ? $user->status :false,  'text' => [__('dashboard_forms.inactive'), __('dashboard_forms.active')]]))
    </div>
</div>
<div class="row">
    <div class="col-lg-6 form-group">
        <div>
            <label for="">{{__('dashboard_forms.image')}}</label>
            <input type="file" class="demo custom-file-img" name="image_path"
                   value="{{ isset($user) ? $user->image_path ?? '' : '' }}"
                   data-jpreview-container="#demo-5-container">
        </div>
        <div id="demo-5-container" class="jpreview-container">
            @if(isset($user))
                <div class="jpreview-image"
                     style="background-image: url({{$user->imagePath}})"></div>
            @else
                <div class="jpreview-image d-none" style="background-image: url()"></div>
            @endif
        </div>
        {!! $errors->first('image_path', '<span class="form-text text-danger">:message</span>') !!}
    </div>

</div>


