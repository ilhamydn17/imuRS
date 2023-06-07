@extends('templates.custom')

@section('title', 'Login')

@section('content')
<div class="row">
    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
        <div class="login-brand">
            <img src="{{ asset('../custom-image/logo-rs.png') }}" alt="logo" width="130" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Buat Akun Baru</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="text"
                            class="form-control @error('username')
                            is-invalid
                        @enderror"
                            name="username">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="code_identity">Kode Identitas Unit</label>
                        <input id="code_identity" type="text"
                            class="form-control @error('code_identity')
                            is-invalid
                        @enderror"
                            name="code_identity">
                        @error('code_identity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="password" class="d-block">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password')
                               is-invalid
                            @enderror"
                                name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                            <label for="password_confirmation" class="d-block">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-5 text-muted text-center">
            <a href="{{ route('login') }}" class="font-weight-bold">Kembali ke halaman login</a>
          </div>s
        <div class="simple-footer">
            Copyright &copy; Stisla 2018 | Developed by <span><a href="">Ilham Yudantyo</a></span>
        </div>
    </div>
</div>
@endsection
