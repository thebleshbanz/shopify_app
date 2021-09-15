@extends('shopify-app::layouts.default')

@section('content')
    <div class="container">
        <form role="form" method="POST" action="{{ route('settings.update', $setting) }}" enctype="multipart/form-data" id="update_setting">
            {{ method_field('PUT') }}
            @csrf
            <input type="hidden" id="shop_id" name="shop_id" value="{{ $setting->shop_id }}" >
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title fw-bold bg-gray-100 p-3">Wishlist Button Settings</h2>
                    <div class="row align-items-start">
                        <div class="col p-3">
                            <div class="mb-3 d-flex align-items-center">
                                <label for="activated" class="col-sm-6 col-form-label">App Activated</label>
                                <div class="check-box">
                                    <input type="checkbox" class="form-control-checkbox" id="activated" name="activated" {{ ($setting->activated == 1) ? 'checked' : '' }} >
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="redirect_product_page" class="col-sm-6 col-form-label">Redirect to Product page</label>
                                <div class="check-box">
                                    <input type="checkbox" class="form-control-checkbox" id="redirect_product_page" name="redirect_product_page" {{ ($setting->redirect_product_page == 1) ? 'checked' : '' }} >
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="disable_guests" class="col-sm-6 col-form-label">Disable for guests</label>
                                <div class="check-box">
                                    <input type="checkbox" class="form-control-checkbox" id="disable_guests" name="disable_guests" {{ ($setting->disable_guests == 1) ? 'checked' : '' }} >
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="wishlist_btn_size" class="col-sm-6 col-form-label">Wishlist Button size</label>
                                <div class="check-box w-100">
                                    <select class="form-select" id="wishlist_btn_size" name="wishlist_btn_size">
                                        <option {{ ($setting->wishlist_btn_size == '25') ? 'selected' : '' }} >25%</option>
                                        <option {{ ($setting->wishlist_btn_size == '50') ? 'selected' : '' }} >50%</option>
                                        <option {{ ($setting->wishlist_btn_size == '75') ? 'selected' : '' }} >75%</option>
                                        <option {{ ($setting->wishlist_btn_size == '100') ? 'selected' : '' }} >100%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="wishlist_btn_color" class="col-sm-6 col-form-label">Wishlist Btn Bg Color</label>
                                <div class="check-box w-100">
                                    <input type="color" class="form-control form-control-color" id="wishlist_btn_color" name="wishlist_btn_color" value="{{ ($setting->wishlist_btn_color) ? $setting->wishlist_btn_color : '' }}" title="Choose your color">
                                </div>
                            </div>
                        </div>
                        <div class="col p-3">
                            <div class="mb-3 d-flex align-items-center">
                                <label for="is_heart_icon" class="col-sm-6 col-form-label">Heart Icon In Wishlist Btn</label>
                                <div class="check-box">
                                    <input type="checkbox" class="form-control-checkbox" id="is_heart_icon" name="is_heart_icon" {{ ($setting->is_heart_icon == 1) ? 'checked' : '' }} >
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="is_wishlist_collection" class="col-sm-6 col-form-label">Wishlist Button on Collection</label>
                                <div class="check-box">
                                    <input type="checkbox" class="form-control-checkbox" id="is_wishlist_collection" name="is_wishlist_collection" {{ ($setting->is_wishlist_collection == 1) ? 'checked' : '' }} >
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="share_social_media" class="col-sm-6 col-form-label">Allow share on social media</label>
                                <div class="check-box">
                                    <input type="checkbox" class="form-control-checkbox" id="share_social_media" name="share_social_media" {{ ($setting->share_social_media == 1) ? 'checked' : '' }} >
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="share_social_media" class="col-sm-6 col-form-label">Reminder Mail?</label>
                                <div class="check-box">
                                    <input type="checkbox" class="form-control-checkbox" id="share_social_media" name="share_social_media" {{ ($setting->share_social_media == 1) ? 'checked' : '' }} >
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="mail_recursive_days" class="col-sm-6 col-form-label">Reminder Mail No. of days</label>
                                <div class="check-box">
                                    <input type="text" class="form-control" id="mail_recursive_days" name="mail_recursive_days" value="{{ ($setting->mail_recursive_days) ? $setting->mail_recursive_days : '' }}" >
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label for="wishlist_label_btn" class="col-sm-6 col-form-label">Wishlist Button Label</label>
                                <div class="check-box">
                                    <input type="text" class="form-control" id="wishlist_label_btn" name="wishlist_label_btn" value="{{ ($setting->wishlist_label_btn) ? $setting->wishlist_label_btn : '' }}" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2 col-sm-2">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
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
            title: 'Settings',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection
