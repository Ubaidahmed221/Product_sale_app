 <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">{{ getAppData('logo_first_text') }}</span>{{ getAppData('logo_second_text') }}</h1>
                </a>
               <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>{{ getAppData('location') }}</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ getAppData('email') }}</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ getAppData('phone') }}</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            @foreach (getMenu('quik_link_1') as $menus)

                            <a class="text-dark mb-2" href="{{ $menus->full_url }}"><i class="fa fa-angle-right mr-2"></i>{{ $menus->name }}</a>
                            @endforeach
                           
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            @foreach (getMenu('quik_link_2') as $menus1)

                            <a class="text-dark mb-2" href="{{ $menus1->full_url }}"><i class="fa fa-angle-right mr-2"></i>{{ $menus1->name }}</a>
                            @endforeach
                           
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                    required="required" />
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="{{ route('index') }}">{{ getAppData('site_name') }}</a>. All Rights Reserved. Designed
                    by
                    <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a><br>
                    Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
