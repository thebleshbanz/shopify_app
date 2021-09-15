@extends('shopify-app::layouts.default')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12" role="main">
                <div class="bs-docs-section">
                    
                    <div class="card mb-4 box-shadow">
                        <div class="card-header"> 
                            <h4 class="my-0 font-weight-normal text-white">Integration</h4>
                        </div>
                        <div class="card-body">
<!-- 
                            <div class="row mb-4">
                                <h6>Step-1</h6>
                                <p>Kindly Put below code where you want show Add Wishlist button</p>
                                <br>
                                <pre style="background-color: #f2f2f3;" >
                                    <code>
                                        &lt;div class="ps-wishlist-btn"&gt;
                                            &lt;ps-wishlist-btn :shop_id='&#123;&#123;shop.id&#125;&#125;' :product='&#123;&#123;-product &#124; json-&#125;&#125;'  :customer_id=' &#123;&#37; if customer &#37;&#125; &#123;&#123; customer.id &#125;&#125; &#123;&#37; else &#37;&#125; 0 &#123;&#37; endif &#37;&#125; ' &gt;&lt;/ps-wishlist-btn&gt;
                                        &lt;/div&gt;
                                    </code>
                                </pre>
                            </div>

                            <div class="row mb-4">
                                <h6>Step-2</h6>
                                <p>While app installed first of all below event triggered.</p>
                                <ol>
                                    <li>1. Store Some basic store info on app server. </li>
                                    <li>2. Our Snippet code which put in wishlist template liquid file to display wishlist page. </li>
                                    <li>3. Create a Store page title "Wishlist" with template suffix to display wishlist page. </li>
                                </ol>
                            </div>

                            <div class="row mb-4">
                                <h6>Step-3</h6>
                                <p>While app Uninstalled some below event triggered.</p>
                                    <ol>
                                        <li>1. Delete Store data. </li>
                                        <li>2. Delete wishlists of store. </li>
                                        <li>3. Delete all store settigns for wishlist. </li>
                                        <li>4. Cancel the current subscriptions plans. </li>
                                    </ol>
                            </div>
 -->

                            <div class="integration">
                                <h2 class="heading mb-3 pb-3">Step-1</h2>
                                <p></p>
                                <!-- <div id="wrapper">
                                    <pre class="code code-html">
                                        <code>
                                        &lt;div class="ps-wishlist-btn"&gt;
                                            &lt;ps-wishlist-btn :shop_id='&#123;&#123;shop.id&#125;&#125;' :product='&#123;&#123;-product &#124; json-&#125;&#125;'  :customer_id=' &#123;&#37; if customer &#37;&#125; &#123;&#123; customer.id &#125;&#125; &#123;&#37; else &#37;&#125; 0 &#123;&#37; endif &#37;&#125; ' &gt;&lt;/ps-wishlist-btn&gt;
                                        &lt;/div&gt;
                                    
                                    </code>

                                    </pre>    
                                </div> -->
                                

                                <div class="steps mb-5">
                                    <h2 class="mb-4">Step-1</h2>

                                    <h4 class="mb-2">Integrate a Wishlist button in product detail page</h4>
                                    <p>Kindly add the following code snippet where you want show Add Wishlist button in Product Detail Page.</p>
                                    <p>Whrer user can add or remove that product in wishlist page.</p>

                                    <div id="wrapper">
                                        <pre class="code code-html">
                                            <code>
                                            &lt;div class="ps-wishlist-btn"&gt;
                                                &lt;ps-wishlist-btn :shop_id='&#123;&#123;shop.id&#125;&#125;' :product='&#123;&#123;-product &#124; json-&#125;&#125;'  :customer_id=' &#123;&#37; if customer &#37;&#125; &#123;&#123; customer.id &#125;&#125; &#123;&#37; else &#37;&#125; 0 &#123;&#37; endif &#37;&#125; ' &gt;&lt;/ps-wishlist-btn&gt;
                                            &lt;/div&gt;
                                
                                        </code>
                                        
                                        </pre>    
                                    </div>

                                    <h2 class="mb-4">Step-2</h2>

                                    <h4 class="mb-2">To see wishlisted products of customer</h4>
                                    <p>Link the page in main menu or footer to visit wishlist page of products.</p>
                                    <p>The URL of wishlist page will be https://your-store-name.myshopify.com/pages/wishlist </p>
                                             
                                    <h2 class="mb-4">Step-3</h2>
                                    <p class="mb-3">while app installed there are some files added in </p>

                                    <ul class="list-group">
                                      <li class="list-group-item"> <i class="fas fa-file"></i> Templates/page.wishlist.liquid</li>
                                      <!-- <li class="list-group-item"> <i class="fas fa-file"></i> A second item</li>
                                      <li class="list-group-item"> <i class="fas fa-file"></i> A third item</li>
                                      <li class="list-group-item"> <i class="fas fa-file"></i> A fourth item</li>
                                      <li class="list-group-item"> <i class="fas fa-file"></i> And a fifth one</li> -->
                                    </ul>                                                                 
                                    <h2 class="mb-4">Step-4</h2>
                                    <p class="mb-3">while app installed there are automatically store page created with Title Wishlist. </p>      
                                </div> 
                                
                            
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    


@endsection


@section('scripts')
    @parent
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript">
        var AppBridge   = window['app-bridge'];
        var actions     = AppBridge.actions;
        var TitleBar    = actions.TitleBar;
        var Button      = actions.Button;
        var Redirect    = actions.Redirect;
        var titleBarOptions = {
            title: 'Plans',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);


    </script>
@endsection