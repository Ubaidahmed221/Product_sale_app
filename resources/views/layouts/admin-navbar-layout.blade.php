<nav id="sidebar">
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
        <h1><a href="index.html" class="logo"> Hii {{ auth()->user()->name }}</a></h1>
    <ul class="list-unstyled components mb-5">
        <li>
            <a href="{{ route('admin.banners') }}"><span class="fa fa-picture-o mr-3"></span>Banners </a>
        </li>
      <li>
          <a href="{{ route('admin.menus') }}"><span class="fa fa-bars mr-3"></span>Menus </a>
      </li>
      <li>
          <a href="{{ route('admin.categories') }}"><span class="fa fa-list-alt mr-3"></span>Categories </a>
      </li>
      <li>
          <a href="{{ route('admin.variation') }}"><span class="fa fa-list-alt mr-3"></span>Variation </a>
      </li>
      <li>
          <a href="{{ route('admin.products') }}"><span class="fa fa-list-alt mr-3"></span>Products </a>
      </li>
      <li>
          <a href="{{ route('admin.offers') }}"><span class="fa fa-gift mr-3"></span>Offers </a>
      </li>
      <li>
        <a href="{{ route('admin.shipping') }}"><span class="fa fa-truck mr-3"></span>Shipping Zones </a>
    </li>
      <li>
        <a href="#" class="logout-btn" ><span class="fa fa-sign-out mr-3 "></span>Log Out </a>
    </li>

    </ul>

</nav>
