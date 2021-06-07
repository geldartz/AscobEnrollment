@if(Auth::user()->type == "user")
{{-- @extends('layouts.homepage') --}}

@section('content')

@endsection

@else

@extends('layouts.app')

@section('content')

@endsection
@endif