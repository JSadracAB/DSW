@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        {{-- Link list --}}
        @include('community.partials.list-links')

        {{-- Link form --}}
        @include('community.partials.add-link')
        
    </div>
    {{$links->links()}}

</div>

@stop