@extends('layouts.app')

@section('PageCss')
    <link href="/css/slick.css" rel="stylesheet"/>
    <link href="{{mix('/css/home.css')}}" rel="stylesheet">
    <style>
        .marquee {
            width: 100%;
            overflow: hidden;
            white-space: nowrap;
        }
        .marquee__seperator {
            margin: 0 2rem;
        }
        .marquee__item {
            display: inline-block;
            will-change: transform;
            -webkit-animation: marquee 25s linear infinite;
            animation: marquee 25s linear infinite;
        }
        @-webkit-keyframes marquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-100%);
            }
        }
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-100%);
            }
        }
        .marquee {
            background-color: rgb(128, 190, 112);
            padding: .6rem 0;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    @include('flash::message')

    <div class="marquee">
        <div class="marquee__item">
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
        </div>
        <div class="marquee__item">
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
            {{__('From 07 June we open for all sellers!')}}
            <span class="marquee__seperator"></span>
        </div>
    </div>

    <section class="home-head">
        <div class="home-head-container">
            <h1>{{__('Selling and buying road bikes made easy')}}</h1>
            <h2>{{__('Share the joy of riding')}}</h2>
            <div class="home-head-buttons">
                <a href="{{ route('sell')}}" class="btn home-btn-1">
                    <span>{{__('Sell')}} </span>
                    <span>{{__('I want to sell a bike')}}</span>
                </a>
                {{--                <a href="{{ route('buy') }}" class="btn home-btn-2">--}}
                <a href="{{ route('shop.index') }}" class="btn home-btn-2">
                    <span>{{__('Buy')}}</span>
                    <span>{{__('I want to buy a bike')}}</span>
                </a>
            </div>

            <div class="chevron-block">
                <div class="chevron"></div>
                <div class="chevron"></div>
                <div class="chevron"></div>
            </div>
        </div>
        <picture class="home-head-picture">
            <source srcset="/img/head-bike-m.webp" type="image/webp" media="(max-width: 767px)">
            <source srcset="/img/home-head-bike-m.png" type="image/png" media="(max-width: 767px)">
            <source srcset="/img/home-head-bike.webp" type="image/webp">
            <source srcset="/img/home-head-bike.png" type="image/png">
            <img src="/img/home-head-bike.png" alt="buycycle" width="230" height="476">
        </picture>


        <div class="home-head-after">
            <div class="navbar">
                <img src="/img/logo-footer.png" alt="buycycle" width="279" height="52">
            </div>
        </div>
    </section>

    <section class="home-info-section">
        <div class="home-info-section-container">
            <div class="home-info-section-item">
                <img src="/img/Premium-Check.svg" alt="{{__('Premium Check')}}" width="65" height="88">
                <h2>{{__('Premium Check')}}</h2>
                <p>{{__('If wanted the User can pay extra, and the bike will be checked and if needed repaired by buycycle, The user can be sure that, the bike he buys, is completely repaired')}}</p>
            </div>
            <div class="home-info-section-item">
                <img src="/img/Safe-payment.svg" alt="{{__('Safe payment')}}" width="65" height="88">
                <h2>{{__('Safe payment')}}</h2>
                <p>{{__('At buycycle the platform pays and not the buyer, Means if something goes wrong the buyer gets his money back and the seller can be sure that he gets his money and can’t be scammed')}}</p>
            </div>
            <div class="home-info-section-item">
                <img src="/img/Easy-Shipping.svg" alt="{{__('Easy Shipping')}}" width="65" height="88">
                <h2>{{__('Easy Shipping')}}</h2>
                <p>{{__('The Seller gets scandalized Packaging and the bike will be picked up from home. So you can sell the bike, without stress, fast and secure')}}</p>
            </div>
            <div class="home-info-section-item">
                <img src="/img/Buyer-Protection.svg" alt="{{__('Buyer Protection')}}" width="65" height="88">
                <h2>{{__('Buyer Protection')}}</h2>
                <p>{{__('If the bike is not how the seller represented it, he can send it back to buycycle and the buyer gets the money back')}}</p>
            </div>
            <div class="home-info-section-item">
                <img src="/img/Personal-Consultation.svg" alt="{{__('Personal Consultation')}}" width="65" height="88">
                <h2>{{__('Personal Consultation')}}</h2>
                <p>{{__('If somebody has questions regarding a bike, or the user is not sure which size or bike is the right one, he can contact them')}}</p>
            </div>
            <div class="home-info-section-item">
                <img src="/img/Customer-Satisfaction4.svg" alt="{{__('Customer Satisfaction')}}" width="85" height="88">
                <h2>{{__('Customer Satisfaction')}}</h2>
                <p>{{__('97% of all buyers and sellers are satisfied with their experience at buycycle and would recommend the marketplace')}}</p>
            </div>
        </div>
    </section>

    <section class="home-what-we-do">
        <picture>
            <source srcset="/img/what-img-2.png" type="image/jpg">
            <img src="/img/what-img-2.png" alt="{{__('What we do')}}" width="936" height="767" loading="lazy">
        </picture>

        <div class="home-what-we-do-content">
            <h2>{{__('What we do')}}</h2>

            <p>{{__('What we do text1,')}}</p>
            <p>{{__('What we do text3')}}</p>
            <p>{{__('What we do text4')}}</p>
            <a href="{{route('what_we_do')}}" class="btn btn_green">{{__('Read more')}}</a>
        </div>
    </section>

    <section class="home-who-we-are">
        <div class="home-who-we-are-container">
            <h2>{{__('Who we are')}}</h2>

            <p>{{__('Who we are text1')}}</p>

            <p>{{__('Who we are text2')}}</p>

            <p>{{__('Who we are text3')}}</p>

            <a href="/about" class="btn btn_green">{{__('Read more')}}</a>
        </div>

        <picture>
            <source srcset="/img/who-we-are-2-m.webp" type="image/webp" media="(max-width: 767px)">
            <source srcset="/img/who-we-are-2-m.jpg" type="image/png" media="(max-width: 767px)">
            <source srcset="/img/who-we-are-2.webp" type="image/webp">
            <source srcset="/img/who-we-are-2.jpg" type="image/jpg">
            <img src="/img/who-we-are-2.jpg" alt="{{__('Who we are')}}" width="1903" height="1269" loading="lazy">
        </picture>
    </section>

    <section class="home-whats-new">
        <div class="home-whats-new-content">
            <h2>{{__('Whats new?')}}</h2>

            <p>{{__('Whats new text1')}}</p>

            <p>{{__('Whats new text2')}}</p>

            <p>{{__('Whats new text3')}}</p>
            <a href="{{route('blog.index')}}" class="btn btn_green">{{__('Read more')}}</a>
        </div>
        <div class="home-whats-new-pictures">
            <picture>
                <source srcset="/img/whats-0.webp" type="image/webp">
                <source srcset="/img/whats-0.jpg" type="image/jpg">
                <img src="/img/whats-0.jpg" alt="bike" width="921" height="522" loading="lazy">
            </picture>
            <picture>
                <source srcset="/img/whats-1-2.webp" type="image/webp">
                <source srcset="/img/whats-1-2.jpg" type="image/jpg">
                <img src="/img/whats-1-2.jpg" alt="bike" width="921" height="522" loading="lazy">
            </picture>
            <picture>
                <source srcset="/img/whats-2-2.jpg" type="image/jpg">
                <img src="/img/whats-2-2.jpg" alt="bike" width="768" height="473" loading="lazy">
            </picture>
            <picture>
                <source srcset="/img/whats-3-2.webp" type="image/webp">
                <source srcset="/img/whats-3-2.jpg" type="image/jpg">
                <img src="/img/whats-3-2.jpg" alt="bike" width="459" height="419" loading="lazy">
            </picture>
            <picture>
                <source srcset="/img/whats-4-2.webp" type="image/webp">
                <source srcset="/img/whats-4-2.jpg" type="image/jpg">
                <img src="/img/whats-4-2.jpg" alt="bike" width="451" height="420" loading="lazy">
            </picture>
            <picture>
                <source srcset="/img/whats-5-2.webp" type="image/webp">
                <source srcset="/img/whats-5-2.jpg" type="image/jpg">
                <img src="/img/whats-5-2.jpg" alt="bike" width="458" height="418" loading="lazy">
            </picture>
            <picture>
                <source srcset="/img/whats-6-2.webp" type="image/webp">
                <source srcset="/img/whats-6-2.jpg" type="image/jpg">
                <img src="/img/whats-6-2.jpg" alt="bike" width="921" height="473" loading="lazy">
            </picture>
        </div>
    </section>

    <section class="home-feedback-slider-section">
        <div class="home-feedback-slider-container">
            <h2 class="text-center">{{__('What say our clients')}}</h2>
            <div class="home-feedback-slider">
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Sascha.jpg" alt="Sascha" width="83" height="83" loading="lazy" style="background-color: #f8f8f7;">
                            <div class="home-feedback-item-user-name">
                                <h3>Sascha St</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Fahrradverkauf leicht gemacht</h4>
                        <p>Fahrradverkauf extrem leicht und zuverlässig gemacht: Hab einen Käufer schnell gefunden,
                            1 Tag später war das Verpackungsmaterial bei mir zu Hause, Spedition kommt nach kurzer
                            Abstimmung wenige Tage später zum Abholen. Bezahlung erfolgt sicher über die Plattform.
                            Richtig nützlicher Service, da der Verkauf von höherwertigen Fahrrädern ansonstendoch
                            recht umständlich ist. Das Team ist auch super nett,auf Anfragen wurde schnell und
                            sympathisch geantwortet. Auf jeden Fall top und empfehlenswert, 5
                        </p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Alex.jpg" alt="Alex Fi" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Alex Fi</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Gute Idee für Verkäufer & Käufer</h4>
                        <p>"Gute Idee für Verkäufer & Käufer hochwertiger bikes.
                            Verschafft ein gewisses Maß an Sicherheit,
                            wenn man blind kaufen muss, d.h der Kaufpartner zu weit weg wohnt.
                            Guter Service mit Kartonversand/Abholung durch Spedition etc.
                            Nicht ganz günstig mit der Versandoption, spart aber natürlich Arbeit und Zeit…Und wichtig
                            finde ich, dass Radfahrer hinter der Seite stecken, vermutlich ist der support
                            entsprechend gut, wenn man ihn braucht! Viel Erfolg 🍀"</p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Rod.jpg" alt="Rod" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Rod</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Maximale Begeisterung</h4>
                        <p>"Extrem starke Plattformumsetzung und Nutzererfahrung. Vor allem dann aber auch die
                            Kombination mit Experten-Knowhow und Service-Offering (Pick-up bzw. Versand)
                            dahinter, empfinde ich als sehr wertvoll. Habe beim Kauf meines Bikes insgesamt eine sehr,
                            sehr gute Erfahrung gemacht im Hinblick auf Vertrauen und Geschwindigkeit bei der Kommunikation und Lieferung."
                        </p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Valenttina.jpg" alt="Valenttina Obrist" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Valenttina Obrist</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Mega Plattform - übersichtlich & unkompliziert</h4>
                        <p>"Coole Auswahl, durch die Filterfunktion habe ich super schnell das passende Einstiegsrennrad gefunden! Abwicklung
                            war auch total easy und unkompliziert! Danke dem Team - freu mich auf meine erste Ausfahrt und Teil der Buycycle Familie zu sein!!"</p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Jannina.jpg" alt="Jannina Halle" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Jannina Halle</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Absolute Weiterempfehlung Danke</h4>
                        <p>"Hab kurzfristig nach einem Rennrad gesucht, was aufgrund der aktuellen Nachfrage fast unmöglich war.
                            Bin per Zufall auf Buycycle gestoßen und zack - drei Stunden später hatte ich mein neues
                            altes Rad in der Hand. Die Jungs waren super flexibel und die Abwicklung mehr
                            als unkompliziert! Absolute Weiterempfehlung! ☺️ Danke!"
                        </p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Tom.jpg" alt="Tom" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Tom</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Tolle Verkaufserfahrung</h4>
                        <p>Tolle Verkaufserfahrung. Immer prompter und kompetenter Support. Weiter so und viel Erfolg!!</p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/LK.jpg" alt="LK" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>LK</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Im Fahhrad Himmel</h4>
                        <p>"Im Fahrrad Himmel.
                            Abwicklung des Verkaufs meines alten Rads war super einfach und der Service super engagiert und freundlich.
                            Macht weiter so!"
                        </p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Bernd.jpg" alt="Bernd Hartmann" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Bernd Hartmann</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Super Plattform</h4>
                        <p>"Super Plattform, um sein gebrauchtes Rennrad zu verkaufen. Mein Rad war innerhalb von 3 Tagen verkauft nach Onlinestellung.
                            Sehr empfehlenswert!"</p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Andres.jpg" alt="Andres Jäger" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Andres Jäger</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Ohne Stress in 48h verkauft!</h4>
                        <p>"War superleicht, die Anzeige zu erstellen, die technischen Daten hat Buycycle online hinzugefügt.
                            In weniger als 48 Stunden war das bike verkauft, ohne Besichtigungen und telefonische Nachfragen…👍👍"</p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Carla.jpg" alt="Carla Leonie" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Carla Leonie</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Schneller und sicherer Kauf und aufmerksamer Kundenservice</h4>
                        <p>"So eine unkomplizierte Abwicklung und netter Kontakt. Habe mein neues altes Fahrrad außerdem im
                            Originalkarton mit Originalmontageanleitung und -werkzeug super schnell per Spedition erhalten.
                            Tolle Plattform! Kann ich nur empfehlen."
                        </p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Fred.jpg" alt="Fred" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Fred</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Super Plattform</h4>
                        <p>Super Plattform. Tolle Idee und perfekter Service. Danke und viel Erfolg euch</p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Antonia.jpg" alt="Antonia" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Antonia</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Schneller & einfacher Verkauf</h4>
                        <p>"Mein Fahrrad wurde innerhalb von wenigen Stunden verkauft. Super stressfrei.
                            Selten so schnell eine Rückmeldung von einem Kundenservice bekommen. Danke Jungs!"</p>
                    </a>
                </div>
                <div>
                    <a href="https://de.trustpilot.com/review/buycycle.de" class="home-feedback-item" rel="nofollow" target="_blank">
                        <div class="home-feedback-item-user">
                            <img src="/img/Florian.jpg" alt="Florian" width="83" height="83" loading="lazy">
                            <div class="home-feedback-item-user-name">
                                <h3>Florian</h3>
                                <div class="Stars" style="--rating: 5;"></div>
                            </div>
                        </div>
                        <h4>Einfach, übersichtlich und sicher! TOP!</h4>
                        <p>"Sehr übersichtliche Plattform und super einfache Anzeigenerstellung. Keine unnötigen Diskussionen, sondern das
                            Cube direkt nach zwei Tagen verkauft bekommen. Abgesicherte Bezahlung einfach TOP!"</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="/js/slick.js"></script>
    <script>
        $(document).ready(function(){
            $('.home-feedback-slider').slick({
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: false,
                prevArrow:"<button type='button' class='slick-prev'><div class=\"long-arrow-left\"></div></button>",
                nextArrow:"<button type='button' class='slick-next'><div class=\"long-arrow-right\"></div></button>",
                // autoplay: true,
                // autoplaySpeed: 2000,

                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            // adaptiveHeight: true
                        }
                    }
                ]});
        });
    </script>
@endsection
