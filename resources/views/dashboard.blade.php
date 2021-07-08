@extends('shopify-app::layouts.default')

@section('content')
    @include('partials.activate-modal')
    <!-- <x-package-alert/> -->
    <x-package-status type="positive"   title="Today's wishists"        number="32"  growth="9"/>
    <x-package-status type="negative"   title="Yesterday's wislists"    number="20"  growth="20"/>
    <x-package-status type="normal"     title="Total wislists"          number="430" growth="0"/>
    
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        var AppBridge = window['app-bridge'];
        var actions = AppBridge.actions;
        var TitleBar = actions.TitleBar;
        var Button = actions.Button;
        var Redirect = actions.Redirect;
        var titleBarOptions = {
            title: 'Dashboard',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);

        function setupTheme(){
            axios.post('{{ route("configureTheme") }}', {
                firstName: 'Fred',
                lastName: 'Flintstone'
            })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    </script>
@endsection
