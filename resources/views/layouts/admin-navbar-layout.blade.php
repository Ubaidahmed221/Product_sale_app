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

    </ul>

</nav>
