<div class="col-md-8">
    <h1 class="title"><a class="text-info" href="/community">Community</a>

        @if (isset($channel))
        - {{ strtoupper($channel->title) }}
        @endif

    </h1>

    {{-- Lista de links --}}

    @include('community.partials.flash-message')

    @if (count($links) > 0)
    <ul>
        @foreach ($links as $link)
        <li class="row">

            <div class="likes px-3 col-1">
                <img src="{{asset('images/like.png')}}" alt="Likes">
                <p class="ml-1">{{$link->users()->count()}}</p>
            </div>

            <div class="links col-9">
                <div>
                    <p>
                        <a href="{{$link->link}}" target="_blank">
                            {{$link->title}}
                        </a>
                    </p>
                    <a href="/community/{{ $link->channel->slug }}" style="color: {{ $link->channel->color }}">{{$link->channel->slug}}</a>
                    <small>Contributed by: <b class="creator">{{$link->creator->name}}</b> {{$link->updated_at->diffForHumans()}}</small>
                </div>
            </div>
            <div class="channels col-2">
                <span class="label label-default" style="background: {{ $link->channel->color }}">
                    {{ strtoupper($link->channel->title) }}
                </span>
            </div>
        </li>
        @endforeach
    </ul>
    @else
    <p>"No contributions yet"</p>
    @endif

</div>