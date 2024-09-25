@extends('admin.layouts.login')

@section('content')

<form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <div class="card">
        <div class="row align-items-center text-center">
            <div class="col-md-12">
                <div class="card-body">
                    <img src="/assets/admin2/images/logo-dark.png" alt="" class="img-fluid mb-4">
                    <h4 class="mb-3 f-w-400">Đăng nhập</h4>
                    <div class="form-group mb-3">
                        <label class="floating-label" for="Email">Email </label>
                        <input type="text" class="form-control" name="email" id="Email" placeholder="">
                    </div>
                    <div class="form-group mb-4">
                        <label class="floating-label" for="Password">Password</label>
                        <input type="password" class="form-control" name="password" id="Password" placeholder="">
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

                    <button class="btn btn-block btn-primary mb-4">Đăng nhập</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
