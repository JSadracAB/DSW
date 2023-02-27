<div class="col-md-8">
    <h1 class="title"><a class="text-info" href="/community">Community</a>

        @if (isset($channel))
        - {{ strtoupper($channel->title) }}
        @endif

    </h1>

    <ul class="nav my-3">
        <li class="nav-item">
            <!-- Si se pasa el parametro 'popular', el link permanece activo, en caso contrario se desactiva -->
            <a class="nav-link {{request()->exists('popular') ? '' : 'disabled' }}" href="{{request()->url()}}">Most recent</a>
        </li>
        <li class="nav-item">
            <!-- Si se pasa el parametro 'popular', el link se desactiva, en caso contrario permanece activado -->
            <a class="nav-link {{request()->exists('popular') ? 'disabled' : '' }}" href="?popular">Most popular</a>
        </li>
    </ul>

    {{-- Lista de links --}}

    @include('community.partials.flash-message')

    @if (count($links) > 0)
    <ul>
        @foreach ($links as $link)
        <li class="row">

            <div class="likes col-2 col-sm-2 col-md-2 col-lg-auto col-auto">
                <form method="POST" action="/votes/{{ $link->id }}">
                    {{ csrf_field() }}
                    <button class="btn {{ Auth::check() && Auth::user()->votedFor($link) ? 'btn-outline-success' : 'btn-outline-secondary' }}" {{ Auth::guest() ? 'disabled' : '' }}>
                        <div class="likes">
                            <i class="fa-regular fa-thumbs-up fa-lg" title="Like"></i>
                            <p>{{$link->users()->count()}}</p>
                        </div>
                    </button>
                </form>
            </div>

            <div class="links col col-sm col-md col-lg">
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

            <div class="channels col-2 col-sm-2 col-md-2 col-lg-auto">
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