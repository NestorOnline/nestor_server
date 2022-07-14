@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="container">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="margin-top: 50px;background: lightgray">

                <center>
                    <div class="card" style="margin-top: 50px;">
                        <div class="card-header">
                            <img src="{{asset('img/nestor_logo.png')}}" style="width: 100px" alt="">
                        </div>

                        <div class="card-header">
                            <h1> Sign In</h2>
                        </div>
                </center>
                <div class="card-body">
                    <form method="POST" action="{{url('/loginpage_password')}}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="mobile" type="text"
                                    class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                    value="{{ old('mobile') }}" placeholder="mobile" required autocomplete="mobile"
                                    autofocus>

                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row mb-0">




                            <center>
                                <div class="col-md-12">
                                    <button type="submit" style="width: 100%" class="btn btn-primary">
                                        {{ __('Sign In') }}
                                    </button>
                                </div>
                            </center>

                        </div>
                    </form>
                </div>

            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>

@endsection