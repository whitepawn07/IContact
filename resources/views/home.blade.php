@extends('layouts.app')

@section('content')
@auth
<main class="py-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <maincomponent></maincomponent>
            </div>
        </div>
    </div>
</main>
@endauth
@endsection
