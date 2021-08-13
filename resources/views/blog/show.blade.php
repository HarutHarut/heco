@extends('layouts.app')

@section('PageCss')
    <link href="{{asset('/css/blog.css')}}" rel="stylesheet">
@endsection

@section('content')


    <section class="single-blog-page">
        <div class="single-blog-container w-100">
            <div class="single-blog-left">
                <div class="single-blog-content w-100">
                    <div>
                        <h1>{{$article->data->title ?? ''}}</h1>
                        <img src="{{$article->imageThumb()}}" alt="" width="710" height="305" class="single-blog-head-img">

                        {!! $article->data->description !!}

                       <span class="single-blog-data">{{__('Published')}} <i>{{m_locale() == 'en' ? $article->created_at->format('d M Y') : $article->created_at->format('d.m.Y')}}</i></span>
                    </div>
                </div>
                @if(count($articles))
                <div class="recommended-content">
                    <p>{{__("recommended")}}</p>
                        <div class="recommended-container">
                            @foreach($articles as $item)
                            <a class="popular-block" href="{{$item->slug}}">
                                <img src="{{$item->imageThumb(400)}}" alt="" width="227"
                                     height="120"
                                     loading="lazy">
                                <div class="popular-text">
                                    <span>{{$item->data->title ?? ''}}</span>
                                    <p>{!! $item->data->short_description ?? '' !!}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                </div>
                @endif
            </div>
        </div>
    </section>

@endsection
