@extends('layouts/blankLayout')

@section('title', 'Login - RRI')

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
<style>
.authentication-wrapper {
  min-height: 100vh;
}
.login-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}
.login-form {
  width: 450px;
}
.logo-container {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding-left: 4rem;
}
.logo-container img {
  max-width: 400px;
  height: auto;
}
</style>
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="login-container">
      <!-- Login Form -->
      <div class="login-form">
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="{{url('/')}}" class="app-brand-link gap-2">
                <img src="{{ asset('assets/logo.png') }}" alt="RRI Logo" style="height: 50px;">
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1">Welcome to RRI! 👋</h4>
            <p class="mb-6">Please sign-in to your account and start the adventure</p>

            <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST">
              @csrf
              <div class="mb-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" autofocus>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-6 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="mb-8">
                <div class="d-flex justify-content-between mt-8">
                  <div class="form-check mb-0 ms-2">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                    <label class="form-check-label" for="remember-me">
                      Remember Me
                    </label>
                  </div>
                  <a href="{{url('auth/forgot-password-basic')}}">
                    <span>Forgot Password?</span>
                  </a>
                </div>
              </div>
              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
              </div>
            </form>

            <p class="text-center">
              <span>New on our platform?</span>
              <a href="{{url('auth/register-basic')}}">
                <span>Create an account</span>
              </a>
            </p>
          </div>
        </div>
      </div>
      <!-- /Login Form -->

      <!-- RRI Logo -->
      <div class="logo-container">
        <img src="{{ asset('assets/rri.png') }}" alt="RRI Logo">
      </div>
      <!-- /RRI Logo -->
    </div>
  </div>
</div>
@endsection
