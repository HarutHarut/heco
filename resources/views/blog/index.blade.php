@extends('layouts.app')

@section('PageCss')
    <link href="{{asset('/css/blog.css')}}" rel="stylesheet">
@endsection

@section('content')


    <section class="blog-page">

        <div class="d-flex flex-wrap justify-content-between align-items-start blog-banner">
            <h1 class="w-100">{{__('Blog')}}</h1>

            <div class="mt-0 blog-head">
                @isset($articles[0])

                    <div class="blog-head-1">
                        <a href="{{route('blog.show',$articles[0]->slug)}}">
                            <img src="{{$articles[0]->imageThumb()}}" alt="" width="716" height="308">
                            <div class="blog-head-text">
                                <h2 class="blog-head-title">{{ $articles[0]->data->title ?? '' }}</h2>
                                <p>{!! $articles[0]->data->short_description ?? '' !!}
                                </p>
                                <span>{{__('Published')}} <i>{{m_locale() == 'en' ? $articles[0]->created_at->format('d M Y') : $articles[0]->created_at->format('d.m.Y')}}</i></span>
                            </div>
                        </a>
                    </div>

                @endisset
                <div class="blog-container pr-0 pl-0">
                    @foreach($articles as $key => $item)
                        @if($key != 0)
                            <a class="blog-block" href="{{route('blog.show',$item->slug)}}">
                                <img src="{{$item->imageThumb(700)}}" alt="" loading="lazy">
                                <div class="blog-text">
                                    <h3>{{ $item->data->title ?? '' }}</h3>
                                    <p>{!! $item->data->short_description ?? '' !!}</p>
                                    <span
                                        class="blog-data">{{__('Published')}} <i>{{m_locale() == 'en' ? $item->created_at->format('d M Y') : $item->created_at->format('d.m.Y')}}</i></span>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>

            </div>

            <div class="blog-right">
                @if(count($most_popular) !=0 )
                    <h2 class="font-semi-bold">{{__("Most Popular")}}</h2>
                @endif
                <div class="mb-5">
                    @foreach($most_popular as $item)
                        <a href="{{route('blog.show',$item->slug)}}" class="blog-popular-item d-flex">
                            <img src="{{$item->imageThumb(400)}}" alt="" loading="lazy"/>
                            <div class="blog-popular-item-text">
                                <h4>{{ $item->data->title ?? '' }}</h4>
                                <p>{!! $item->data->short_description ?? '' !!}</p>
                                <span>{{__('Published')}} <i>{{m_locale() == 'en' ? $item->created_at->format('d M Y') : $item->created_at->format('d.m.Y')}}</i></span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </section>

@endsection
