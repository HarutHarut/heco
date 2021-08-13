<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name', 'Buycycle')}} - {{__('Dashboard')}}</title>
    <link href="{{mix('/css/dashboard-app.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('dashboard-css')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
          integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
          crossorigin="anonymous"/>
</head>
<body>


<main class="d-flex page">
    <div class="left-menu">
        {{--    iconner    https://preview.keenthemes.com/metronic/demo1/features/icons/svg.html--}}
        <div class="brand d-flex align-items-center">
            <a href="/" class="brand-logo" aria-label="brand"><img alt="Logo" src="/img/logo.png"></a>
            <button class="brand-toggle" type="button" aria-label="minimaize menu">

                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                         height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                        <path
                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                            fill="#494b74" fill-rule="nonzero"
                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)"></path>
                        <path
                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                            fill="#494b74" fill-rule="nonzero" opacity="0.3"
                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)"></path>
                    </g>
                </svg>
                </span>
            </button>
        </div>

        <div id="simple-bar" class="simple-bar">
            <ul class="menu-nav" id="menu-nav">

                <li class="menu-item">
                    <a href="{{route('dashboard')}}" class="menu-link" @if(active_link())aria-expanded="true"
                       style="background-color: transparent!important;"
                       @else aria-expanded="false" @endif>
                        <span class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                               <polygon points="0 0 24 0 24 24 0 24"></polygon>
                               <path
                                   d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                   fill="#000000" fill-rule="nonzero"></path>
                               <path
                                   d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                   fill="#000000" opacity="0.3"></path>
                           </g>
                       </svg>
                        </span>
                        <span class="menu-text">{{__('dashboard_forms.dashboard')}}</span>
                    </a>
                </li>

                <li class="menu-item-group">{{__('dashboard_forms.notifications')}}</li>

                <li class="menu-item">

                    <a class="menu-link" data-toggle="collapse" href="#collapseExample7" role="button"
                       @if(active_link('notifications') || active_link('newbike')) aria-expanded="true"
                       style="background-color: transparent!important;"
                       @else aria-expanded="false" @endif
                       aria-controls="collapseExample7">
                        <span class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                    <path
                                        d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                        fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                        </span>
                        <span class="menu-text">{{__('dashboard_forms.notifications')}}</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="collapse @if(active_link('notifications')  || active_link('newbike')) show @endif"
                         data-parent="#menu-nav" id="collapseExample7">
                        <ul class="menu-nav">
                            <li class="menu-item">
                                <a href="{{route('notifications.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('notifications')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.notifications')}}</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('newbike.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('newbike')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.request')}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-item-group">{{__('dashboard_forms.bookings')}}</li>

                <li class="menu-item">

                    <a class="menu-link" data-toggle="collapse" href="#collapseExample6" role="button"
                       @if(active_link('bookings*') || active_link('purchase')) aria-expanded="true"
                       style="background-color: transparent!important;"
                       @else aria-expanded="false" @endif
                       aria-controls="collapseExample6">
                        <span class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                    <path
                                        d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                        fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                        </span>
                        <span class="menu-text">{{__('dashboard_forms.bookings')}}</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="collapse @if(active_link('bookings*')  || active_link('purchase')) show @endif"
                         data-parent="#menu-nav" id="collapseExample6">
                        <ul class="menu-nav">
                            <li class="menu-item">
                                <a href="{{route('bookings.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('bookings*')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.bookings')}}</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('purchase')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('purchase')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.purchase')}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-item-group">{{__('dashboard_forms.users')}}</li>

                <li class="menu-item">
                    <a href="{{route('users.index')}}" class="menu-link"
                       @if(active_link('users*'))aria-expanded="true"
                       style="background-color: transparent!important;"
                       @else aria-expanded="false" @endif>
                        <span class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                               <polygon points="0 0 24 0 24 24 0 24"></polygon>
                               <path
                                   d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                   fill="#000000" fill-rule="nonzero"></path>
                               <path
                                   d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                   fill="#000000" opacity="0.3"></path>
                           </g>
                       </svg>
                        </span>
                        <span class="menu-text">{{__('dashboard_forms.users')}}</span>
                    </a>
                </li>

                <li class="menu-item-group">{{__('dashboard_forms.articles')}}</li>

                <li class="menu-item">
                    <a href="{{route('articles.index')}}" class="menu-link"
                       @if(active_link('articles*'))aria-expanded="true"
                       style="background-color: transparent!important;"
                       @else aria-expanded="false" @endif>
                        <span class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                               <polygon points="0 0 24 0 24 24 0 24"></polygon>
                               <path
                                   d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z"
                                   fill="#000000" fill-rule="nonzero"></path>
                               <path
                                   d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z"
                                   fill="#000000" opacity="0.3"></path>
                           </g>
                       </svg>
                        </span>
                        <span class="menu-text">{{__('dashboard_forms.articles')}}</span>
                    </a>
                </li>

                <li class="menu-item-group">{{__('dashboard_forms.data')}}</li>

                <li class="menu-item">
                    <a class="menu-link" data-toggle="collapse" href="#collapseExample" role="button"
                       @if(active_link('bikes*') || active_link('bike/details*')) aria-expanded="true"
                       style="background-color: transparent!important;"
                       @else aria-expanded="false" @endif
                       aria-controls="collapseExample">
                        <span class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                    <path
                                        d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                        fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                        </span>
                        <span class="menu-text">{{__('dashboard_forms.bikes')}}</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="collapse @if(active_link('bikes*')  || active_link('bike/details*') || active_link('DBbikes*')) show @endif"
                         data-parent="#menu-nav" id="collapseExample">
                        <ul class="menu-nav">
                            <li class="menu-item">
                                <a href="{{route('bikes.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('bikes*')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.bikes')}}</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('DBbikes.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('DBbikes*')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.DBbikes')}}</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('details.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('bike/details*')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.bike_details')}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-item">
                    <a href="{{route('categories.index')}}" class="menu-link"
                       @if(active_link('categories*'))aria-expanded="true"
                       style="background-color: transparent!important;"
                       @else aria-expanded="false" @endif>
                        <span class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"></rect>
                              <rect fill="#000000" opacity="0.3" x="4" y="4" width="8" height="16"></rect>
                              <path
                                  d="M6,18 L9,18 C9.66666667,18.1143819 10,18.4477153 10,19 C10,19.5522847 9.66666667,19.8856181 9,20 L4,20 L4,15 C4,14.3333333 4.33333333,14 5,14 C5.66666667,14 6,14.3333333 6,15 L6,18 Z M18,18 L18,15 C18.1143819,14.3333333 18.4477153,14 19,14 C19.5522847,14 19.8856181,14.3333333 20,15 L20,20 L15,20 C14.3333333,20 14,19.6666667 14,19 C14,18.3333333 14.3333333,18 15,18 L18,18 Z M18,6 L15,6 C14.3333333,5.88561808 14,5.55228475 14,5 C14,4.44771525 14.3333333,4.11438192 15,4 L20,4 L20,9 C20,9.66666667 19.6666667,10 19,10 C18.3333333,10 18,9.66666667 18,9 L18,6 Z M6,6 L6,9 C5.88561808,9.66666667 5.55228475,10 5,10 C4.44771525,10 4.11438192,9.66666667 4,9 L4,4 L9,4 C9.66666667,4 10,4.33333333 10,5 C10,5.66666667 9.66666667,6 9,6 L6,6 Z"
                                  fill="#000000" fill-rule="nonzero"></path>
                          </g>
                      </svg>
                        </span>
                        <span class="menu-text">{{__('dashboard_forms.categories')}}</span>
                    </a>
                </li>

                <li class="menu-item-group">{{__('dashboard_forms.brand')}}</li>

                <li class="menu-item">
                    <a class="menu-link" data-toggle="collapse" href="#collapseExample1" role="button"
                       @if(active_link('brands*') || active_link('brand/models*')) aria-expanded="true"
                       style="background-color: transparent!important;"
                       @else aria-expanded="false" @endif
                       aria-controls="collapseExample1">
                        <span class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                    <path
                                        d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                        fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                        </span>
                        <span class="menu-text">{{__('dashboard_forms.brands')}}</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div class="collapse @if(active_link('brands*')  || active_link('brand/models*')) show @endif"
                         data-parent="#menu-nav" id="collapseExample1">
                        <ul class="menu-nav">
                            <li class="menu-item">
                                <a href="{{route('brands.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('brands*')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.brands')}}</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('models.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('brand/models*')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.models')}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="menu-item-group">{{__('dashboard_forms.country')}}</li>

                <li class="menu-item">
                    <a href="{{route('countries.index')}}" class="menu-link"
                       @if(active_link('countries*'))aria-expanded="true"
                       style="background-color: transparent!important;"
                       @else aria-expanded="false" @endif>
                        <span class="svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"></rect>
                              <rect fill="#000000" opacity="0.3" x="4" y="4" width="8" height="16"></rect>
                              <path
                                  d="M6,18 L9,18 C9.66666667,18.1143819 10,18.4477153 10,19 C10,19.5522847 9.66666667,19.8856181 9,20 L4,20 L4,15 C4,14.3333333 4.33333333,14 5,14 C5.66666667,14 6,14.3333333 6,15 L6,18 Z M18,18 L18,15 C18.1143819,14.3333333 18.4477153,14 19,14 C19.5522847,14 19.8856181,14.3333333 20,15 L20,20 L15,20 C14.3333333,20 14,19.6666667 14,19 C14,18.3333333 14.3333333,18 15,18 L18,18 Z M18,6 L15,6 C14.3333333,5.88561808 14,5.55228475 14,5 C14,4.44771525 14.3333333,4.11438192 15,4 L20,4 L20,9 C20,9.66666667 19.6666667,10 19,10 C18.3333333,10 18,9.66666667 18,9 L18,6 Z M6,6 L6,9 C5.88561808,9.66666667 5.55228475,10 5,10 C4.44771525,10 4.11438192,9.66666667 4,9 L4,4 L9,4 C9.66666667,4 10,4.33333333 10,5 C10,5.66666667 9.66666667,6 9,6 L6,6 Z"
                                  fill="#000000" fill-rule="nonzero"></path>
                          </g>
                      </svg>
                        </span>
                        <span class="menu-text">{{__('dashboard_forms.countries')}}</span>
                    </a>
                </li>

                <li class="menu-item-group">{{__('dashboard_forms.settngs')}}</li>

                <li class="menu-item">
                    <a class="menu-link" data-toggle="collapse" href="#collapseExample4" role="button"
                       @if(active_link('pages*') || active_link('settings*') || active_link('change*')) aria-expanded="true"
                       style="background-color: transparent!important;"
                       @else aria-expanded="false" @endif
                       aria-controls="collapseExample4">
                        <span class="svg-icon">
                           <svg
                               xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                               width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24"></rect>
                        <path
                            d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z"
                            fill="#000000"></path>
                        <path
                            d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z"
                            fill="#000000" opacity="0.3"></path>
                    </g>
                </svg>
                        </span>
                        <span class="menu-text">{{__('dashboard_forms.settings')}}</span>
                        <i class="menu-arrow"></i>
                    </a>

                    <div
                        class="collapse @if(active_link('pages*') || active_link('change*') || active_link('settings*')) show @endif"
                        data-parent="#menu-nav" id="collapseExample4">
                        <ul class="menu-nav">
                            <li class="menu-item">
                                <a href="{{route('pages.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('pages*')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.pages')}}</span>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="{{route('settings.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('settings*')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.settings')}}</span>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="{{route('change.index')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('change*')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.change-password')}}</span>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="{{route('translation_manager')}}" class="menu-link">
                                    <i class="menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text"
                                          @if(active_link('translation*')) style="color: #ffffff!important;" @endif>{{__('dashboard_forms.translations')}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

    </div>

    <div class="wrapper w-100 d-flex flex-column">

        <header class="header">
            <div class="d-flex justify-content-between align-items-center">

                <a href="/" class="brand-logo d-xl-none">
                    <img src="/img/logo.png" width="100" alt="Logo">
                </a>

                <a href="#" class="notification-btn ml-auto position-relative dropdown-toggle" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i>{{notifications()['count'] == 0 ? null : notifications()['count']}}</i>
                    <span class="svg-icons">
                       <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" viewBox="0 0 20.635 26.035"><defs><style>.a {
                                       fill: currentColor;
                                   }</style></defs><g transform="translate(0)"><path class="a"
                                                                                     d="M184.9,465.044a3.933,3.933,0,0,0,7.2,0Z"
                                                                                     transform="translate(-178.186 -441.358)"/><path
                                   class="a"
                                   d="M199.3,2.487a8.846,8.846,0,0,1,3.021.529V2.9a2.9,2.9,0,0,0-2.9-2.9h-.24a2.9,2.9,0,0,0-2.9,2.9v.115A8.863,8.863,0,0,1,199.3,2.487Z"
                                   transform="translate(-188.98 0)"/><path class="a"
                                                                           d="M72.864,96.979H53.8a.777.777,0,0,1-.766-.6.741.741,0,0,1,.408-.843,4.046,4.046,0,0,0,1.231-1.674,19.34,19.34,0,0,0,1.284-7.653,7.376,7.376,0,0,1,14.752-.029q0,.015,0,.029a19.34,19.34,0,0,0,1.284,7.653,4.045,4.045,0,0,0,1.231,1.674.741.741,0,0,1,.408.843A.777.777,0,0,1,72.864,96.979Zm.367-1.434h0Z"
                                                                           transform="translate(-53.013 -74.821)"/></g>
                       </svg>
                   </span>
                </a>

                <div class="dropdown-menu dropdown-menu-right p-0">

                    <div class="dropdown-notification simple-bar">
                        @foreach(notifications()['data'] as $bike)
                            <a href="@if($bike->name){{route('notifications.index')}}@else{{route('newbike.index')}}@endif"
                               class="notification-link">
                                @if(!$bike->name)
                                    <div class="notification-title" style="color: green">
                                        {{__('dashboard_forms.new_bike_request')}}
                                    </div>
                                @endif
                                <div class="notification-title">
                                    {{$bike->name ?? $bike->email}}
                                </div>
                                <div class="notification-time">
                                    {{ \Carbon\Carbon::parse($bike->created_at)->format('d M H:i') }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @if(count(notifications()['data']) < notifications()['count'])
                        <a href="{{route('notifications.index')}}"
                           class="notification-link-all">{{__('dashboard_forms.see_all')}}</a>
                    @endif
                </div>

                {{--                <a href="/" class="brand-logo d-xl-none">--}}
                {{--                    <img src="{{m_lang_icon_path(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale())}}"--}}
                {{--                        width="100" alt="Logo">--}}
                {{--                </a>--}}

                <div class="btn-group lang-drop">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-label="lang"
                            aria-haspopup="true" aria-expanded="false">
                        <img
                            src="{{m_lang_icon_path(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale())}}"
                            alt="" width="20px" height="20px">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right p-3 ">

                        @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localCode => $langItem)
                            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() != $localCode)
                                <a class="text-decoration-none"
                                   href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localCode, null, [], true) }}"
                                   aria-label="language">
                                    <img src="{{m_lang_icon_path($localCode)}}" alt="language"
                                         width="19" height="19">
                                    <span>{{__('auth.'.$localCode)}}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle d-flex align-items-center" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-md-inline-block">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                        @if(Auth::user()->image_path)
                            <img src="{{ Auth::user()->imagePath}}"
                                 width="30" height="30" class="ml-2">
                        @else
                            <span class="flaticon-user ml-2"></span>
                        @endif

                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('personal-information.index') }}" class="dropdown-item">
                            <i class="flaticon2-user-1 mr-2"></i>
                            {{__('dashboard_forms.my_profile')}}
                        </a>
                        <li><a href="#"
                               class="dropdown-item"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="flaticon-logout  mr-2"></i>
                                {{__('Logout')}}
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

                <button class="btn open-menu" type="button">
                    <i class="flaticon2-cross"></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img"
                         focusable="false">
                        <title>Menu</title>
                        <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"
                              d="M4 7h22M4 15h22M4 23h22"></path>
                    </svg>
                </button>
            </div>
        </header>

        <div class="content d-flex flex-column flex-column-fluid">

            @yield('content')
        </div>

    </div>

</main>


<script src="{{ mix('/js/dashboard-app.js') }}"></script>


@yield('dashboard-js')


<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&libraries=places"></script>

<script>

    function initialize() {
        var ac = new google.maps.places.Autocomplete(document.getElementById('search-address'));
        ac.setComponentRestrictions(
            {'country': ['DE'], 'postalCode': []});
    }

    $(function () {
        initialize();
    });

    $(document).ready(function () {
        $('#category_ids').select2();

        $('.bike-brand').change(function (e) {
            e.preventDefault();
            getModels($(this).val(), $(this).data('model'))
        });
    });

    function getModels(val, selected_model)
    {
        console.log(selected_model);
        axios.get('{{route('brand-models')}}', {
            params: {
                brand_id: val
            }
        }).then(resp => {
            let select = $('select[name=brand_model_id]'),
                options = '',
                models = resp.data.models;
            var old_model = '{{old('brand_model_id')}}';
            for (let key in models) {
                let  opt_html = `<option value="${key}">${models[key]}</option>`;
                if(old_model == key || (selected_model && selected_model == key)){
                    opt_html = `<option value="${key}" selected>${models[key]}</option>`;
                }

                options += opt_html;
            }

            select.html(options)
        })
    }

    getModels($('.bike-brand').find(':selected').val(), $('.bike-brand').data('model'));

    $('#object-form-confirm').click(function () {
        $(this).attr('disabled', true);
        $('#object-form').submit();
    });


    $('.category-filter-bike').change(function () {
        $('.category-filter-input').val($(this).val());
        $('.category-filter-form').submit();
    });
    $('.type-filter-bike').change(function () {
        $('.type-filter-input').val($(this).val());
        $('.category-filter-form').submit();
    });

    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 5000);


    // color picker
    var colorList = [ '000000', 'FFFFFF', 'ff0000', 'ffff00', '008000', '0000ff', 'ffa500', '800080',
        '808080' ];
    var picker = $('#color-picker');

    for (var i = 0; i < colorList.length; i++ ) {
        picker.append('<li class="color-item" data-hex="' + '#' + colorList[i] + '" style="background-color:' + '#' + colorList[i] + ';"></li>');
    }

    $('body').click(function () {
        picker.hide();
    });


    $('.call-picker').click(function(event) {
        event.stopPropagation();
        picker.show();
        picker.children('li').hover(function() {
            var codeHex = $(this).data('hex');
            $('.color-holder').css('background-color', codeHex,);
            // console.log($('#pickcolor').val());
            $('#hidden_color').val(codeHex);
        });
    });
</script>

</body>
</html>
