@extends('layouts.admin-layout')

@section('content')
    <h2 class="mb-4">App Data </h2>

    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <form action="{{ route('UpdateAppData') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>logo first text</label>
                    <input type="text" class="form-control" name="logo_first_text" placeholder="Logo first text"
                    value="{{ $data->logo_first_text ?? '' }}"
                        {{-- value="{{ isset($data->logo_first_text ? $data->logo_first_text : '') }}" --}}
                        >
                    @error('logo_first_text')
                        <span class="error-message"> {{ $mssage }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>logo second text</label>
                    <input type="text" class="form-control" name="logo_second_text" placeholder="Logo second text"
                        {{-- value="{{ isset($data->logo_second_text ? $data->logo_second_text : '') }}" --}}
                        value="{{ $data->logo_second_text ?? '' }}"
                        >
                    @error('logo_second_text')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>heading</label>
                    <input type="text" class="form-control" name="heading" placeholder="heading"
                        {{-- value="{{ isset($data->heading ? $data->heading : '') }}" --}}
                          value="{{ $data->heading ?? '' }}"
                        >
                    @error('heading')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>location</label>
                    <input type="text" class="form-control" name="location" placeholder="location"
                        {{-- value="{{ isset($data->location ? $data->location : '') }}" --}}
                          value="{{ $data->location ?? '' }}"
                        >
                    @error('location')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="email"
                        {{-- value="{{ isset($data->email ? $data->email : '') }}" --}}
                          value="{{ $data->email ?? '' }}"
                        >
                    @error('email')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" name="phone" placeholder="phone"
                       value="{{ $data->phone ?? '' }}"
                        {{-- value="{{ isset($data->phone ? $data->phone : '') }}" --}}
                        >
                    @error('phone')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>site name</label>
                    <input type="text" class="form-control" name="site_name" placeholder="site_name"
                        {{-- value="{{ isset($data->site_name ? $data->site_name : '') }}" --}}
                           value="{{ $data->site_name ?? '' }}"
                        >
                    @error('site_name')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Facebook URL</label>
                    <input type="text" class="form-control" name="facebook" placeholder="facebook"
                        {{-- value="{{ isset($data->facebook ? $data->facebook : '') }}" --}}
                           value="{{ $data->facebook ?? '' }}"
                        >
                    @error('facebook')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Twitter URL</label>
                    <input type="text" class="form-control" name="twitter" placeholder="twitter"
                        {{-- value="{{ isset($data->twitter ? $data->twitter : '') }}" --}}
                           value="{{ $data->twitter ?? '' }}"
                        >
                    @error('twitter')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Linkedin URL</label>
                    <input type="text" class="form-control" name="linkedin" placeholder="linkedin"
                        {{-- value="{{ isset($data->linkedin ? $data->linkedin : '') }}" --}}
                           value="{{ $data->linkedin ?? '' }}"
                        >
                    @error('linkedin')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Instagram URL</label>
                    <input type="text" class="form-control" name="instagram" placeholder="instagram"
                        value="{{ $data->instagram ?? '' }}">
                    @error('instagram')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Youtube URL</label>
                    <input type="text" class="form-control" name="youtube" placeholder="youtube"
                        value="{{ $data->youtube ?? '' }}">
                    @error('youtube')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Contact Touch text</label>
                    <input type="text" class="form-control" name="contact_touch_text"
                        placeholder="Contact Touch Text"
                        value="{{ $data->contact_touch_text ?? '' }}">
                    @error('contact_touch_text')
                        <span class="error-message">{{ $mssage }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <input type="submit" value="Update" class="btn btn-primary">



    </form>
@endsection
