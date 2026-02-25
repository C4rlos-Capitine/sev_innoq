@extends('layouts.app')

@section('content')
<body>
       <div class="d-flex flex-column align-items-center">
    <h1>Login</h1>
    @if($errors->any())
        <div style="color:red">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
 
        <form id="form-login" method="POST" action="{{ url('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
            </div>
            <div>
                <label class="form-label">Password</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <div>
                <label><input type="checkbox" name="remember"> Lembrar-me</label>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Entrar</button>
            
        </form>
        <p>Não tem conta? <a href="{{ url('register') }}">Registar</a></p>
    </div>
    </div>
</body>
</html>
@endsection
