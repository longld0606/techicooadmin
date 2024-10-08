@extends('budvar.layouts.login')

@section('content')

<form method="POST" action="{{ route('budvar.login') }}">
    @csrf
    <div class="card">
        <div class="row align-items-center text-center">
            <div class="col-md-12">
                <div class="card-body"> 
                    <h4 class="mb-3 f-w-400">budvar</h4>
                    <div class="form-group mb-3">
                        <label class="floating-label" for="Email">budvar </label>
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
