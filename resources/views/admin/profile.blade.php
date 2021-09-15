@extends('shopify-app::layouts.default')

@section('content')
    
    <div class="container">
        <div class="card">
            <div class="card-body">
                <!--Section: Contact v.2-->
                <section class="mb-4">

                    <!--Section heading-->
                    <h2 class="h1-responsive profile font-weight-bold text-center my-4">User Profile</h2>
                    <!--Section description-->
                    <p class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within
                        a matter of hours to help you.</p>

                    <div class="row">

                        <!--Grid column-->
                        <div class="col-md-8 offset-md-2 mb-md-0 mb-5">
                            <form role="form" method="POST" action="{{ route('user.update', $user) }}" enctype="multipart/form-data" id="submit_contactus" class="p-3 bg-gray-100">
                                {{ method_field('PUT') }}
                                @csrf
                                <input type="hidden" id="shop_id" name="shop_id" value="{{ ($user) ? $user->shop_id : '' }}" >

                                <!--Grid row-->
                                <div class="row">

                                    <!--Grid column-->
                                    <div class="col-md-6">
                                        <div class="md-form mb-3">
                                            <label for="store_name" class="">Store Name</label><span class="text-danger">&#42;</span>
                                            <input type="text" id="store_name" name="store_name" class="form-control" value="{{ ($user) ? $user->name : '' }}" disabled>
                                            @if ($errors->has('store_name'))
                                                <p class="text-danger" role="alert">
                                                    <strong>{{ $errors->first('store_name') }}</strong>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <!--Grid column-->

                                    <!--Grid column-->
                                    <div class="col-md-6">
                                        <div class="md-form mb-3">
                                            <label for="email" class="">Your email</label><span class="text-danger">&#42;</span>
                                            <input type="text" id="email" name="email" class="form-control" value="{{ ($user) ? $user->original_email : '' }}" disabled>
                                            @if ($errors->has('email'))
                                                <p class="text-danger" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <!--Grid column-->

                                </div>
                                <!--Grid row-->

                                <!--Grid row-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="md-form mb-3">
                                            <label for="domain" class="">Domain</label><span class="text-danger">&#42;</span>
                                            <input type="text" id="domain" name="domain" class="form-control" value="{{ ($user) ? $user->domain : '' }}" disabled>
                                            @if ($errors->has('domain'))
                                                <p class="text-danger" role="alert">
                                                    <strong>{{ $errors->first('domain') }}</strong>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--Grid row-->


                                <div class="text-center text-md-left">
                                    <!-- <button type="submit" class="btn btn-primary">Update</button> -->
                                </div>

                            </form>
                            <div class="status"></div>
                        </div>
                        <!--Grid column-->

                    </div>

                </section>
                <!--Section: Contact v.2-->
            </div>
        </div>
    </div>

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
            title: 'Profile',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection
