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
  justify-content: center ;
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
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Masukkan username" value="{{ old('username') }}" autofocus>
                @error('username')
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
                  <!-- <a href="{{url('auth/forgot-password-basic')}}">
                    <span>Forgot Password?</span>
                  </a> -->
                </div>
              </div>
              <div class="mb-6">
                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
              </div>
            </form>

            <!-- <p class="text-center">
              <span>New on our platform?</span>
              <a href="{{url('auth/register-basic')}}">
                <span>Create an account</span>
              </a>
            </p> -->
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const form = document.getElementById('formAuthentication');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const rememberMeCheckbox = document.getElementById('remember-me');

    // Check if there are saved credentials
    const savedUsername = localStorage.getItem('rememberedUsername');
    const savedPassword = localStorage.getItem('rememberedPassword');
    
    if (savedUsername && savedPassword) {
        usernameInput.value = savedUsername;
        passwordInput.value = savedPassword;
        rememberMeCheckbox.checked = true;
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        if (rememberMeCheckbox.checked) {
            // Save credentials to localStorage
            localStorage.setItem('rememberedUsername', usernameInput.value);
            localStorage.setItem('rememberedPassword', passwordInput.value);
        } else {
            // Remove saved credentials if "Remember Me" is unchecked
            localStorage.removeItem('rememberedUsername');
            localStorage.removeItem('rememberedPassword');
        }
    });
});
</script>
@endsection
