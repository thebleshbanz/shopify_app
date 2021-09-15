@extends('shopify-app::layouts.default')

@section('content')
    <!-- ======= card wrapper row start ======= -->
    <div class="home">
      <div class="card-wrapper">
        <div class="row">
          <!--- row block start-->
          <div class="col-lg-4">
            <div class="card mb-4">
              <div class="card-header">
                <div class="title"><i class="fas fa-user me-2"></i>Total Store Customers</div>
              </div>
              <div class="card-body">
                <p># of customers of shopify Store</p>
                <span>{{ $statistics['total_customer'] }}</span>
                <!-- <p># of usrs that have added to Wishlist</p> -->
              </div>
            </div>
          </div>
          <!--- row block end-->
          <!--- row block start-->
          <div class="col-lg-4">
            <div class="card mb-4">
              <div class="card-header">
                <div class="title"><i class="fas fa-heart me-2"></i>Total Wishlisted Customers</div>
              </div>
              <div class="card-body">
                <p># of customers that have added product to Wishlist</p>
                <span>{{ $statistics['total_wishlist_customer'] }}</span>
              </div>
            </div>
          </div>
          <!--- row block end-->
          <!--- row block start-->
          <div class="col-lg-4">
            <div class="card mb-4">
              <div class="card-header">
                <div class="title"><i class="fas fa-heart me-2"></i>Total Wishlisted Products</div>
              </div>
              <div class="card-body">
                <p># of products that have added Wishlist</p>
                <span>{{ $statistics['total_wishlist_product'] }}</span>
              </div>
            </div>
          </div>
          <!--- row block end-->
          <!--- row block start-->
          <div class="col-lg-4">
            <div class="card mb-4">
              <div class="card-header">
                <div class="title"><i class="fas fa-shopping-cart me-2"></i>Total Add to cart</div>
              </div>
              <div class="card-body">
                <p># of products that have added to Store Cart</p>
                <span>{{ $statistics['total_wishlist_product_cart'] }}</span>
              </div>
            </div>
          </div>
          <!--- row block end-->
        </div>
      </div>
      <!-- ======= card wrapper row end ======= -->
      <!-- ======= customer wrapper row start ======= -->
      <div class="customer-wrapper">
        <div class="row">
          <!--- row block start-->
          <div class="col-lg-3">
            <div class="customer-inner">
              <h3>Customer Wishlists</h3>
              <a href="{{ route('customers') }}" class="btn btn-raised btn-danger">Show All</a>
            </div>
          </div>
          <!--- row block end-->
          <!--- row block start-->
          <div class="col-lg-3">
            <div class="customer-inner">
              <h3>Top Products</h3>
              <a href="{{ route('products') }}" class="btn btn-raised btn-danger">Show All</a>
            </div>
          </div>
          <!--- row block end-->
          <!--- row block start-->
          <div class="col-lg-3">
            <div class="customer-inner"></div>
          </div>
          <!--- row block end-->
        </div>
      </div>
      <!-- ======= customer wrapper row end ======= -->
      <!-- ======= chart wrapper row start ======= -->
      <div class="chart-wrapper">
        <div class="row">
          <!--- row block start-->
          <div class="col-lg-3">
            <div class="chart-inner"></div>
          </div>
          <!--- row block end-->
          <!--- row block start-->
          <div class="col-lg-3">
            <div class="chart-inner"></div>
          </div>
          <!--- row block end-->
          <!--- row block start-->
          <div class="col-lg-3">
            <div class="chart-inner"></div>
          </div>
          <!--- row block end-->
          <!--- row block start-->
          <div class="col-lg-3">
            <div class="chart-inner"></div>
          </div>
          <!--- row block end-->
        </div>
      </div>
      <!-- ======= chart wrapper row end ======= -->
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
