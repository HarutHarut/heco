@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection

@section('content')


    <section class="position-relative info-section">
        <img src="https://uploads-ssl.webflow.com/6043dc4cbfa49d0d160e91c0/606c2b7a40b9334b4dfaae4f_Back-of-the-bike-Small.jpg" sizes="(max-width: 479px) 325.046875px, (max-width: 1251px) 100vw, 1251px"
             srcset="https://uploads-ssl.webflow.com/6043dc4cbfa49d0d160e91c0/606c2b7a40b9334b4dfaae4f_Back-of-the-bike-Small-p-500.jpeg 500w,
             https://uploads-ssl.webflow.com/6043dc4cbfa49d0d160e91c0/606c2b7a40b9334b4dfaae4f_Back-of-the-bike-Small-p-800.jpeg 800w,
              https://uploads-ssl.webflow.com/6043dc4cbfa49d0d160e91c0/606c2b7a40b9334b4dfaae4f_Back-of-the-bike-Small-p-1080.jpeg 1080w,
               https://uploads-ssl.webflow.com/6043dc4cbfa49d0d160e91c0/606c2b7a40b9334b4dfaae4f_Back-of-the-bike-Small.jpg 1251w" alt="what" class="bg-bike">
        <h1>{{__('IHR HABT DIE RÄDER')}}
            <br>
            <span>{{__('DU')}}</span>
            {{__('HAST DIE WAHL')}}
        </h1>
        <p>{{__('Hier kannst du schon bald gebrauchte Rennräder kaufen und verkaufen')}}</p>
        <p><i>{{__('sicher - unkompliziert - schnell')}}</i></p>
        <p class="d-mob-none">{{__('In nur zwei Minuten kannst du dein Rennrad bewerten lassen und zum Verkauf stellen')}}<br>
            {{__('Wir kümmern uns um den Versand und die komplette Zahlungsabwicklung')}}
        </p>
        <p  class="d-mob-none">{{__('Buycycle ist der Rennrad Marktplatz auf dem jeder schnell sein Traumrad findet und dabei hilft wertvolle Ressourcen zu schonen')}}</p>

{{--        <div class="d-flex align-items-center d-mob-none">--}}
{{--            <span class="scroll-span">Scroll</span>--}}
{{--            <div class="chevron-block">--}}
{{--                <div class="chevron"></div>--}}
{{--                <div class="chevron"></div>--}}
{{--                <div class="chevron"></div>--}}
{{--            </div>--}}
{{--        </div>--}}

    </section>

    <section class="info-section-2">
        <h2 class="text-center d-mob-none">{{__('DIE VORTEILE VON BUYCYCLE')}}</h2>

        <div class="w-row">
            <div class="w-col-3">
                <div class="white-box">
                    <img src="https://uploads-ssl.webflow.com/6043dc4cbfa49d0d160e91c0/6044bf0eae96da72d7f9fa97_Einfach.png"
                          alt="Grüner Kreis mit Symbol für Einfachheit" class="grid-image">
                    <h3>{{__('Einfach')}}</h3>
                    <p>{{__('Kaufe und verkaufe gebrauchte Rennräder so simpel wie in einem Online Shop
                        Eine strukturierte Abwicklung ohne unnötige Nachrichten Zum Versand schicken
                        wir dem Verkäufer die Verpackung und später die Spedition direkt vor die Haustür')}}
                    </p>
                </div>
            </div>
            <div class="w-col-3">
                <div class="white-box">
                    <img src="https://uploads-ssl.webflow.com/6043dc4cbfa49d0d160e91c0/6044bfd95a521e292b58984e_Sicher.png"
                         alt="Grüner Kreis mit Symbol für Sicherheit" class="grid-image">
                    <h3>{{__('Sicher')}}</h3>
                    <p>{{__('Voller Schutz für Verkäufer und Käufer! Wir garantieren einen reibungslosen
                        Ablauf und kümmern uns um die Zahlung und versicherten Versand
                        Falsche oder beschädigte Räder nehmen wir natürlich zurück')}}
                    </p>
                </div>
            </div>
            <div class="w-col-3">
                <div class="white-box">
                    <img src="https://uploads-ssl.webflow.com/6043dc4cbfa49d0d160e91c0/6044bf4868e4a666334698eb_Schnell.png"
                         alt="Grüner Kreis mit Symbol für Schnelligkeit" class="grid-image">
                    <h3>{{__('schnell')}}</h3>
                    <p>{{__('Mithilfe unserer Fahrraddatenbank bekommst du alle Infos zu jedem Bike egal
                        ob du es verkaufen oder kaufen möchtest Damit ist dein Rad innerhalb von wenigen
                        Klicks online und der neue Besitzer findet schnell sein Traum-Bike')}}
                    </p>
                </div>
            </div>
            <div class="w-col-3">
                <div class="white-box">
                    <img src="https://uploads-ssl.webflow.com/6043dc4cbfa49d0d160e91c0/6044bf545a521ea72f589760_Nachhaltig.png"
                         alt="Grüner Kreis mit Symbol für Nachhaltigkeit" class="grid-image">
                    <h3>{{__('nachhaltig')}}</h3>
                    <p>{{__('Viele Rennräder werden nur 3 Jahre aktiv genutzt - Gehe verantwortungsvoll
                        mit wertvollen Ressourcen um und verlängere die Nutzungsdauer vorhandener Rennräder
                        Durch wiederverwendbare Versandboxen entsteht dabei kein Müll')}}
                    </p>
                </div>
            </div>
        </div>

    </section>

    <section class="bg-gradient">
        <div class="info-section-2">
            <h2 class="text-center">{{__('BUYCYCLE KURZ ERKLÄRT')}}</h2>
            <h3 class="text-center">{{__('WIE VERKAUFE ICH EIN RAD MIT BUYCYCLE?')}}</h3>
            <iframe class="embedly-embed" src="//cdn.embedly.com/widgets/media.html?src=https%3A%2F%2Fwww.youtube.com%2Fembed%2FIxImwgsP3nk%3Ffeature%3Doembed&amp;display_name=YouTube&amp;url=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DIxImwgsP3nk&amp;image=https%3A%2F%2Fi.ytimg.com%2Fvi%2FIxImwgsP3nk%2Fhqdefault.jpg&amp;key=96f1f04c5f4143bcb0f2e68c87d65feb&amp;type=text%2Fhtml&amp;schema=youtube" scrolling="no" title="YouTube embed" frameborder="0" allow="autoplay; fullscreen" allowfullscreen="true"></iframe>

            <h3 class="text-center">{{__('WIE KAUFE ICH EIN RAD MIT BUYCYCLE?')}}</h3>
            <iframe class="embedly-embed" src="//cdn.embedly.com/widgets/media.html?src=https%3A%2F%2Fwww.youtube.com%2Fembed%2FFaFaFVTKXwU%3Ffeature%3Doembed&amp;display_name=YouTube&amp;url=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DFaFaFVTKXwU&amp;image=https%3A%2F%2Fi.ytimg.com%2Fvi%2FFaFaFVTKXwU%2Fhqdefault.jpg&amp;key=96f1f04c5f4143bcb0f2e68c87d65feb&amp;type=text%2Fhtml&amp;schema=youtube" scrolling="no" title="YouTube embed" frameborder="0" allow="autoplay; fullscreen" allowfullscreen="true"></iframe>

        </div>
    </section>

@endsection

