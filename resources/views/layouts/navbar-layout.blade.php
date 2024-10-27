<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    @foreach (getAllCategory() as $category)
                    <div class="nav-item dropdown">
                        @if ($category->children->isNotEmpty())
                        <a href="#" class="nav-link" data-toggle="dropdown">{{ $category->name }}
                            <i class="fa fa-angle-down float-right mt-1"></i></a>

                            <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                              @foreach ($category->children as $childCategory)
                              <a href="" class="dropdown-item">{{ $childCategory->name }}</a>

                              @endforeach
                            </div>
                        @else
                        <a href="" class="nav-item nav-link">{{ $category->name }}</a>
                        @endif
                    </div>
                    @endforeach





                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">{{ getAppData('logo_first_text') }}</span>{{ getAppData('logo_second_text') }}</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        @foreach (getMenu('main') as $main)
                        @if ($main->children->isNotEmpty())
                        <div class="nav-item dropdown">
                            <a href="{{ $main->full_url }}" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ $main->name }}</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                @foreach ($main->children as $child)
                                <a href="{{ $child->full_name }}" class="dropdown-item">{{ $child->name }}</a>

                                @endforeach
                            </div>
                        </div>
                        @else
                        <a href="{{ $main->full_url }}" class="nav-item nav-link">{{ $main->name }}</a>

                        @endif

                        @endforeach


                     </div>
                    <div class="navbar-nav ml-auto py-0">
                        <a href="{{ route('loginView') }}" class="nav-item nav-link">Login</a>
                        <a href="{{ route('registerView') }}" class="nav-item nav-link">Register</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
