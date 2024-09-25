@extends('admin.layouts.login')

@section('content')
<div class="login-box">
    <div class="login-logo"> <a href="/"><b>CO</b> &nbsp;ADMIN</a> </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Quản lý hệ thống</p>
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <div class="input-group-text"> <span class="bi bi-envelope"></span> </div>
                </div>

                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                </div>

                @if (count($errors) > 0)
                <div class="mb-3">
                    <ul style="list-style: none; padding-left: 0">
                        @foreach ($errors->all() as $error)
                        <li class="text-danger"> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <!--begin::Row-->
                <div class="row">
                    <div class="col-8">
                        <div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"> <label class="form-check-label" for="flexCheckDefault">
                                Remember Me
                            </label> </div>
                    </div> <!-- /.col -->
                    <div class="col-4">
                        <div class="d-grid gap-2"> <button type="submit" class="btn btn-primary">Sign In</button> </div>
                    </div> <!-- /.col -->
                </div>
                <!--end::Row-->
            </form>
        </div>
    </div>
</div>
@endsection
