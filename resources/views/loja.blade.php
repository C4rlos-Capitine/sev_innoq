@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1>Loja</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

<div class="row products responsive-md-class responsive-xl-class responsive-lg-class">
    <div class="row mb-4">
        @foreach ($normas as $norma)
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card" id="{{ $norma['codigo'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $norma['titulo'] }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $norma['codigo'] }}</h6>
                        <p class="card-text">{{ substr($norma['descricao'], 0, 100) }}...</p>   
                        <div class="pricing-meta">
                            <span class="badge badge-primary">{{ number_format($norma['precos'][0]['valor'], 2, ',', ' ') }} MT</span>
                        </div>
                        <a href="/norma/{{ $norma['id_norma'] }}" class="btn btn-primary mt-2"><i class="fas fa-eye"></i></a>
                        <button type="button" class="btn btn-success mt-2" onclick="addToCart({{ $norma['id_norma'] }}, '{{ addslashes($norma['titulo']) }}', {{ $norma['precos'][0]['valor'] }})"><i class="fas fa-shopping-cart"></i></button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>

@endsection

@section('scripts')
<script>
    const provincias = @json($provincias ?? []);

    document.addEventListener('DOMContentLoaded', function(){
        const provinciasSelect = document.getElementById('provincia_select');
        if(provinciasSelect && provincias.length){
            provincias.forEach(p => {
                const opt = document.createElement('option'); 
                opt.value = p.id_provincia; 
                opt.text = p.nome_provincia; 
                provinciasSelect.appendChild(opt);
            });
        }
    });
</script>
@endsection
