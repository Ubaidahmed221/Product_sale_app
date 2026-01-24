@extends('layouts.layout')

@section('content')

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Referral Link</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('index')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Affiliate</p>
            </div>
        </div>  
    </div>

    <div class="container pt-5">
        <div class="card p-4">
            <label class="mb-2 fw-bold"> Your Referral Link:</label>

            <div class="input-group">

                <input type="text" id="referralLink" class="form-control" value="{{$referalLink}}" readonly >
                <button class="btn btn-primary" onclick="copyreferrallink()"  > Copy </button>
            </div>

            <small class="text-muted mt-2 d-block" >Share this to earn affiliate commission</small>

            <div class="mt-4"> 
                <h6>QR Code</h6>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($referalLink) }}" alt="" title="Referral QR Code" />
            </div>
          
        </div>
    </div>    
@endsection

@push('script')
    <script>
        function copyreferrallink(){
            var copyText = document.getElementById("referralLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/
            document.execCommand("copy");
            navigator.clipboard.writeText(copyText.value);
            alert("Copied the referral link: " + copyText.value);
        }
    </script>
@endpush