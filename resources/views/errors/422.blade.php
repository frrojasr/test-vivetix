@extends('layouts.app')

@section('content')
<div class="alert alert-danger">
    <strong>¡Error de validación!</strong>
    <br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>

@endsection