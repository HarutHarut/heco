@extends('layouts.app')
@section('PageCss')
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .preloader {
            display: flex !important;
        }
    </style>
@endsection
@section('scripts')
    <script>
        var stripe = Stripe('<?php echo config('services.stripe.key') ?>');
        stripe.redirectToCheckout({
            sessionId: '<?php echo $session_id ?>'
        }).then(function (result) {
        });
    </script>
@endsection
