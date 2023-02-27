@extends('layouts.app')

@section('content')

<div class="container mt-2">
    <div class="row">

        {{-- Link list --}}
        @include('community.partials.list-links')

        {{-- Link form --}}
        @include('community.partials.add-link')
        
    </div>
    {{ $links->appends($_GET)->links() }}

</div>

@stop