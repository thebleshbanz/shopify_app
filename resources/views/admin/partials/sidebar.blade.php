<!-- 	<ul class="side-nav">
	    <li class="side-nav-item menuitem-active">
	      <a data-bs-toggle="collapse" href="#sidebarDashboards"  aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link collapsed"><i class="fas fa-heart me-2"></i><span> Wishlist </span><span class="menu-arrow"></span></a>
	      <div class="collapse" id="sidebarDashboards" style="">
	        <ul class="side-nav-second-level">
	            <li><a href="{{ route('home') }}" class="side-nav-link @if(Request::path() == '/') active @endif "><i class="fas fa-desktop me-2"></i>Dashboard</a></li>
	            <li><a href="{{ route('customers') }}" class="side-nav-link @if(Request::path() == '/') active @endif "><i class="fas fa-user-friends me-2"></i>Customers</a></li>
	            <li><a href="{{ route('products') }}" class="side-nav-link @if(Request::path() == '/') active @endif "><i class="fas fa-umbrella me-2"></i>Products</a></li>
	            <li><a href="{{ route('settings', ['user_id' => Auth::user()->id] ) }}" class="side-nav-link @if(Request::path() == '/') active @endif "><i class="fas fa-tools me-2"></i>Setting</a></li>
	        </ul>
	      </div>
	    </li>
	    <li class="side-nav-item"><a href="{{ route('plans') }}" class="side-nav-link"><i class="fas fa-edit me-2"></i>Plans</a></li>
	    <li class="side-nav-item"><a href="{{ route('integrations') }}" class="side-nav-link"><i class="fas fa-hand-point-up me-2"></i>Integrations</a></li>
	    <li class="side-nav-item"><a href="#" class="side-nav-link"><i class="fas fa-headphones-alt me-2"></i>Help & Support</a></li>
	    <li class="side-nav-item"><a href="{{ route('contact_us') }}" class="side-nav-link"><i class="fas fa-mobile me-2"></i>Contact Us</a></li>
	</ul> -->

	<ul class="side-nav">
	    <li class="side-nav-item {{ Request::routeIs('home') ? 'menuitem-active' : '' }}"><a href="{{ route('home') }}" class="side-nav-link"><i class="fas fa-desktop me-2"></i>Dashboard</a></li>
		<li class="side-nav-item {{ Request::routeIs('customers') ? 'menuitem-active' : '' }}"><a href="{{ route('customers') }}" class="side-nav-link"><i class="fas fa-user-friends me-2"></i>Customers</a></li>
		<li class="side-nav-item {{ Request::routeIs('products') ? 'menuitem-active' : '' }}"><a href="{{ route('products') }}" class="side-nav-link"><i class="fas fa-umbrella me-2"></i>Products</a></li>
		<li class="side-nav-item {{ Request::routeIs('settings') ? 'menuitem-active' : '' }}"><a href="{{ route('settings', ['user_id' => Auth::user()->id] ) }}" class="side-nav-link"><i class="fas fa-tools me-2"></i>Setting</a></li>
	    <li class="side-nav-item {{ Request::routeIs('plans') ? 'menuitem-active' : '' }}"><a href="{{ route('plans') }}" class="side-nav-link"><i class="fas fa-edit me-2"></i>Plans</a></li>
	    <li class="side-nav-item {{ Request::routeIs('integrations') ? 'menuitem-active' : '' }}"><a href="{{ route('integrations') }}" class="side-nav-link"><i class="fas fa-hand-point-up me-2"></i>Integrations</a></li>
	    <!-- <li class="side-nav-item"><a href="#" class="side-nav-link"><i class="fas fa-headphones-alt me-2"></i>Help & Support</a></li> -->
	    <li class="side-nav-item"><a href="{{ route('contact_us') }}" class="side-nav-link"><i class="fas fa-mobile me-2"></i>Contact Us</a></li>
	</ul>