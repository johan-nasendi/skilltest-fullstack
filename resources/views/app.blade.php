<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Johan Nasendi">
    <meta name="description" content=" Documentation API">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS mix -->
    <link href=" {{ mix('css/app.css') }}" rel="stylesheet">

   <!-- Favicon -->
   <link rel="shortcut icon" href="{{asset('/assets/images/favicon.png')}}">

    <!-- Plugins css -->
    <link href="{{asset('/assets/libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/libs/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/libs/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/libs/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />

    <link href="{{asset('/assets/css/bootstrap-dark.min.css')}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="{{asset('/assets/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  </head>

  <body>

    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section"></div>
    </div>
    <div id="wrapper">
        <div id="app">
            <app></app>
        </div>
    </div>
    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <!-- use the latest release -->
    <script src="https://unpkg.com/vuejs-paginate@latest"></script>
    <!-- or use the specify version -->
    <script src="https://unpkg.com/vuejs-paginate@0.9.0"></script>
    <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    <!-- Vendor js -->
    <script src="{{asset('/assets/js/vendor.min.js')}}"></script>
    <script src="{{asset('/assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>
    <script src="{{asset('/assets/libs/mohithg-switchery/switchery.min.js')}}"></script>
    <script src="{{asset('/assets/libs/multiselect/js/jquery.multi-select.js')}}"></script>
    <script src="{{asset('/assets/libs/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/libs/jquery-mockjax/jquery.mockjax.min.js')}}"></script>
    <script src="{{asset('/assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js')}}"></script>
    {{-- <script src="{{asset('/assets/libs/bootstrap-select/js/bootstrap-select.min.js')}}"></script> --}}
    <script src="{{asset('/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/b00263187e.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2/moment.min.js"></script>
    <!-- App js -->
    <script src="{{asset('/assets/js/app.min.js')}}"></script>
    <!-- Init js-->
    <script src="{{asset('/assets/js/pages/form-advanced.init.js')}}"></script>
    {{-- <script src="https://unpkg.com/vue-select@latest"></script> --}}
    <script>
       $(document).ready(function() {
        // Fakes the loading setting a timeout
        setTimeout(function() {
            $('body').addClass('loaded');
        }, 1000);

        });

    </script>

</body>

</html>
