<div id="sidebar-nav" class="sidebar">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<li><a href="{{route('admin.home')}}" class="{{ (( Request::segment(2)=='home' ? 'active' : '' )) }}" title="Dashboard"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
				
				<li class="user-list-cls"><a href="{{route('admin.user')}}" class="{{Request::segment(2)=='user' ? 'active' : '' }}"><i class="lnr lnr-users"></i> <span>User</span></a></li>

                <li class="user-list-cls"><a href="{{route('admin.menu')}}" class="{{Request::segment(2)=='menu' ? 'active' : '' }}"><i class="lnr lnr-users"></i> <span>Menu</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.category')}}" class="{{Request::segment(2)=='category' ? 'active' : '' }}"><i class="lnr lnr-store"></i> <span>Category</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.product')}}" class="{{Request::segment(2)=='product' ? 'active' : '' }}"><i class="fa fa-product-hunt" aria-hidden="true"></i> <span>Product</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.orders')}}" class="{{Request::segment(2)=='orders' ? 'active' : '' }}"><i class="fa fa-product-hunt" aria-hidden="true"></i> <span>Order</span></a></li>

                <li class="orders-list-cls"><a href="{{route('admin.history')}}" class="{{Request::segment(2)=='history' ? 'active' : '' }}"><i class="fa fa-product-hunt" aria-hidden="true"></i> <span>History</span></a></li>

                
			</ul>
		</nav>
	</div>
</div>
