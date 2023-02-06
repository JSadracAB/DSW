@extends('layouts.app')
@section('content')

<h1>Community</h1>

<!-- Link table -->
@foreach ($links as $link)
<li><b>{{$link->title}}</b><small> Contributed by: {{$link->creator->name}} {{$link->updated_at->diffForHumans()}}</small></li>
@endforeach
{{$links->links()}}

@stop