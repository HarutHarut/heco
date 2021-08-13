{{--profile left menu--}}
<div class="profile-menu">

    <span class="open-menu-filter ml-auto"></span>

{{--    <form action="{{route('profile-picture-update')}}" method="post" enctype="multipart/form-data"--}}
{{--          id="profilePicForm">--}}
{{--        @csrf--}}
        <div class="profile-company-img position-relative">
            <div class="account-img-view" id="user-img">
                <img src="{{ Auth::user()->image_path ? Auth::user()->imagePath : asset('/img/user.svg') }}" class="user_photos" alt="">
            </div>
            <div class="avatar-buttons">
                <button type="button" class="btn edit-img" data-toggle="modal" data-target="#myModal"
                        title="Edit avatar">
                    <img src="/img/pencil.svg" alt="" width="11">
                    {{__('Edit')}}
                </button>
            </div>
        </div>
{{--    </form>--}}

    <div class="profile-company-info">
        <h2>{{ Auth::user()->name }}</h2>
    </div>


    <ul class="profile-nav">
        <li>
            <a href="{{route('personal-information.index')}}"
               class="profile-nav-link @if(request()->is('*/personal-information')) active @endif">
                <img src="/img/profile-user.svg" alt="Personal Info" width="20" height="20">
                <span>{{__('Personal Info')}}</span>
            </a>
        </li>
        <li>
            <a href="{{route('payout.index')}}"
               class="profile-nav-link @if(request()->is('*/payout')) active @endif">
                <img src="/img/credit-card.svg" alt="Personal Info" width="20" height="20">
                <span>{{__('Payout')}}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('notifications') }}"
               class="profile-nav-link @if(request()->is('*/notifications')) active @endif">
                <img src="/img/Line.svg" alt="Notifications" width="20" height="20">
                <span>{{__('Notifications')}}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('published-bicycles') }}"
               class="profile-nav-link @if(request()->is('*/published-bicycles')) active @endif">
                <img src="/img/bike.svg" alt="Published bicycles" width="20" height="20">
                <span>{{__('Published bicycles')}}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('favorites') }}" class="profile-nav-link @if(request()->is('*/favorites')) active @endif">
                <img src="/img/love.svg" alt="Favorites" width="20" height="20">
                <span>{{__('Favorites')}}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('my-purchases') }}"
               class="profile-nav-link @if(request()->is('*/my-purchases')) active @endif">
                <img src="/img/purch.svg" alt="My purchases" width="20" height="20">
                <span>{{__('My purchases')}}</span>
            </a>
        </li>
        <li>
            <a href="{{ route('change-password') }}"
               class="profile-nav-link @if(request()->is('*/change-password')) active @endif">
                <img src="/img/locked.svg" alt="Change password" width="20" height="20">
                <span>{{__('Change password')}}</span>
            </a>
        </li>
        <li>
            <a href="#"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();"
               class="profile-nav-link"
            >
                <img src="/img/logout.svg" alt="Logout" width="20" height="20">
                <span>{{__('Logout')}}</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                @csrf
                @method('POST')
            </form>
        </li>
    </ul>
</div>


<div id="myModal" class="modal fade modal-add-img" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h4 class="modal-title">{{__('Edit Photo')}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
            </div>

            <div class="modal-body">
                <div class="d-flex justify-content-center flex-column align-items-center">
                    <div class="fileform">
                        <div id="fileformlabel"></div>
                        <div class="selectbutton">{{__('select picture')}}</div>
                        <input required type="file" name="profile_image" id="upload" onchange="getName(this.value);"/>
                    </div>
                    <br/>
                    <div>
                        <div id="upload-img"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button
                    class="btn btn_green upload-result"
{{--                    onclick="event.preventDefault(); document.getElementById('profilePicForm').submit();"--}}
{{--                    disabled--}}
                    data-dismiss="modal"
                >
                    {{__('Save')}}
                </button>
                <button type="button" class="btn btn_grey" data-dismiss="modal">{{__('Cancel')}}</button>
            </div>
        </div>

    </div>
</div>
{{--end profile left menu--}}


