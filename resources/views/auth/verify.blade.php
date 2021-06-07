@extends('layouts.page')

@section('content')
<section class="breadcrumbs">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
        <h2>Verification</h2>
        <ol>
            <li><router-link to="/">Home</router-link></li>
            <li>Email Verification</li>
        </ol>
        </div>
    </div>
</section>
<div class="container">
    <section class="inner-page" style="color: #444;" >
        <div class="container d-relative">
            <h4>Verify Your Email Address</h4>
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
          <p class="mt-3">
            Before proceeding, please check your email for a verification link. <br>If you did not receive the email <form class="d-inline form-verify" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
          </p>
        
        </div>
      </section>
</div>
@endsection
