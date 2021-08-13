<?php

namespace App\Services;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SeoService
{
    public function seoForPage($page)
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $this->seoTools(config('seo.' . $page . '.meta_keywords_' . $lang),
            config('seo.' . $page . '.meta_title_' . $lang),
            config('seo.' . $page . '.meta_description_' . $lang),
            config('app.url') . config('seo.' . $page . '.image'));
    }

    public function seoTools($keyword, $title, $description, $image = null)
    {
        if (is_array($keyword)) {
            $keyword = implode(',', $keyword);
        }

        SEOMeta::setKeywords($keyword);
        SEOMeta::setTitle($title, false);
        SEOMeta::setDescription($description);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::addProperty('locale', 'en');

//        if ($image) {
//
//            SEOMeta::addMeta('twitter:images0', $image);
//            OpenGraph::addProperty('image', $image);
//        } else {
//
//            OpenGraph::addProperty('image', 'https://aist.global/img/meta/Home-AIST-GLOBAL.jpg');
//            SEOMeta::addMeta('twitter:images0', 'https://aist.global/img/meta/Home-AIST-GLOBAL.jpg');
//        }

        SEOMeta::addMeta('twitter:title', $title);
        SEOMeta::addMeta('twitter:description', $description);

        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'en');
    }

}
