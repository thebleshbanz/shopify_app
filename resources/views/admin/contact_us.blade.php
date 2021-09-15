@extends('shopify-app::layouts.default')

@section('styles')

<style>
    .ps-btn-bg {
        background-color:#c25fe4;
    }
</style>

@endsection

@section('content')
    
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                <p> {{ session('success') }} </p>
            </div>
        @endif
        @if (session('fail'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Danger!</h5>
                <p> {{ session('fail') }} </p>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <!--Section: Contact v.2-->
                <section class="mb-4">

                    <!--Section heading-->
                    <div class="bg-gray-50 p-3 mb-4">
                        <div class="bg-gray-100 p-3">
                            <h2 class="contact h1-responsive font-weight-bold text-center my-2 text-xl text-center leading-6 font-medium text-gray-900">Contact us</h2>
                            <!--Section description-->
                            <p class="text-center w-responsive mx-auto mb-2">Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within
                                a matter of hours to help you.</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <i class="fas fa-envelope mt-2 fa-2x"></i>
                            <p>appsupport@parkhya.com</p>
                        </div>
                    </div>

                    <div class="row">

                        <!--Grid column-->
                        <div class="col-md-10 offset-md-1 mb-md-0 mb-5">
                            <form role="form" method="POST" action="{{ route('contact_us.save') }}" enctype="multipart/form-data" id="submit_contactus" class="p-3 bg-gray-100">
                                @csrf
                                <input type="hidden" id="shop_id" name="shop_id" value="{{ ($user) ? $user->shop_id : '' }}" >

                                <!--Grid row-->

                                <div class="row">

                                    <!--Grid column-->
                                    <div class="col-md-6">
                                        <div class="md-form mb-3">
                                            <label for="name" class="">Store Name</label><span class="text-danger">&#42;</span>
                                            <input type="text" id="store_name" name="store_name" class="form-control">
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
                                            <input type="text" id="email" name="email" class="form-control">
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
                                            <label for="subject" class="">Subject</label><span class="text-danger">&#42;</span>
                                            <input type="text" id="subject" name="subject" class="form-control">
                                            @if ($errors->has('subject'))
                                                <p class="text-danger" role="alert">
                                                    <strong>{{ $errors->first('subject') }}</strong>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--Grid row-->

                                <!--Grid row-->
                                <div class="row">

                                    <!--Grid column-->
                                    <div class="col-md-12">

                                        <div class="md-form mb-3">
                                            <label for="message">Your message</label>
                                            <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
                                        </div>

                                    </div>
                                </div>
                                <!--Grid row-->
                                
                                <!--Grid row-->
                                    <div class="row">
                                        <!--Grid column-->
                                        <div class="col-md-12">
                                            <div class="md-form mb-3">
                                                <label for="message">Upload File</label>
                                                <input type="file" id="contact_file" name="contact_file" class="form-control">
                                                @if ($errors->has('contact_file'))
                                                    <p class="text-danger" role="alert">
                                                        <strong>{{ $errors->first('contact_file') }}</strong>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                <!--Grid row-->

                                <div class="text-center text-md-left">
                                    <button type="submit" class="btn btn-danger">Submit</button>
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
            title: 'Contact Us',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection
