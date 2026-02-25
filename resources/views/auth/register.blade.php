@extends('layouts.app')

@section('content')
<body>
    <h1>Registar</h1>
    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endif
    <form id="form-login" method="POST" action="{{ url('register') }}">
        @csrf
        <div>
            <label class="form-label">Nome</label>
            <br>
            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>
        <div>
            <label class="form-label" >Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label>Password</label>
            <input class="form-control" type="password" name="password" required>
        </div>
        <div>
            <label>Confirmar Password</label>
            <input class="form-control" type="password" name="password_confirmation" required>
        </div>
        <div>
            <button class="btn btn-primary" type="submit">Criar conta</button>
        </div>
    </form>
    <p>Já tem conta? <a href="{{ url('login') }}">Entrar</a></p>
</body>
@endsection
