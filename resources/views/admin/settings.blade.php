@extends('shopify-app::layouts.default')

@section('styles')

<style>
    .py-5 {
        padding-top: 0rem!important;
        padding-bottom: 0rem!important;
    }
</style>

@endsection

@section('content')
    <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
            App Settings
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Basic details of application.
            </p>
        </div>
        <div class="border-t border-gray-200">
            <div class="content-center" >
                <dl>
                    <form role="form" method="POST" action="{{ route('settings.update', $setting) }}" enctype="multipart/form-data" id="update_setting">
                        {{ method_field('PUT') }}
                        @csrf
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                App Activated
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="checkbox" class="form-checkbox" id="activated" name="activated" {{ ($setting->activated == 1) ? 'checked' : '' }} >
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Redirect to Product page
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="checkbox" class="form-checkbox" id="redirect_product_page" name="redirect_product_page" {{ ($setting->redirect_product_page == 1) ? 'checked' : '' }} >
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Disable for guests
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="checkbox" class="form-checkbox" id="disable_guests" name="disable_guests" {{ ($setting->disable_guests == 1) ? 'checked' : '' }} >
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Wishlist Button size
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <select class="form-select block w-1/4 mt-1" id="wishlist_btn_size" name="wishlist_btn_size" >
                                    <option {{ ($setting->wishlist_btn_size == 'Option 1') ? 'selected' : '' }} >Option 1</option>
                                    <option {{ ($setting->wishlist_btn_size == 'Option 2') ? 'selected' : '' }} >Option 2</option>
                                    <option {{ ($setting->wishlist_btn_size == 'Option 3') ? 'selected' : '' }} >Option 3</option>
                                    <option {{ ($setting->wishlist_btn_size == 'Option 4') ? 'selected' : '' }} >Option 4</option>
                                </select>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Wishlist Button Bg Color
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" placeholder="Wishlist Background Color" id="wishlist_btn_color" name="wishlist_btn_color" value="{{ ($setting->wishlist_btn_color) ? $setting->wishlist_btn_color : '' }}"
                                    class="px-2 py-1 placeholder-gray-400 text-gray-600 relative bg-white bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:ring w-1/2 pl-10" />
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Wishlist Button Heart Icon
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="checkbox" class="form-checkbox" id="is_heart_icon" name="is_heart_icon" {{ ($setting->is_heart_icon == 1) ? 'checked' : '' }} >
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Wishlist Button on Collection
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="checkbox" class="form-checkbox" id="is_wishlist_collection" name="is_wishlist_collection" {{ ($setting->is_wishlist_collection == 1) ? 'checked' : '' }} >
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Allow share on social media
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="checkbox" class="form-checkbox" id="share_social_media" name="share_social_media" {{ ($setting->share_social_media == 1) ? 'checked' : '' }} >
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Reminder Mail?
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="checkbox" class="form-checkbox" id="reminder_mail" name="reminder_mail" {{ ($setting->reminder_mail == 1) ? 'checked' : '' }} >
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Reminder Mail No. of days
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" placeholder="Enter No. of days" id="mail_recursive_days" name="mail_recursive_days" value="{{ ($setting->mail_recursive_days) ? $setting->mail_recursive_days : '' }}"
                                    class="px-2 py-1 placeholder-gray-400 text-gray-600 relative bg-white bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:ring w-1/2 pl-10" />
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Wishlist Button Label
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" placeholder="Enter Label of Wishlist button" id="wishlist_label_btn" name="wishlist_label_btn" value="{{ ($setting->wishlist_label_btn) ? $setting->wishlist_label_btn : '' }}"
                                    class="px-2 py-1 placeholder-gray-400 text-gray-600 relative bg-white bg-white rounded text-sm border border-gray-400 outline-none focus:outline-none focus:ring w-1/2 pl-10" />
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <button
                                class="bg-purple-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="submit">
                                Save
                            </button>
                        </div>
                    </form>
                </dl>
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
            title: 'Settings',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection
