<?php

namespace App\Queries;

use App\Models\Channel;
use App\Models\CommunityLink;

class CommunityLinksQuery
{
    public function getByChannel(Channel $channel)
    {
        // Si no, muestra todos los links de dicho canal
        $query = $channel->communityLinks()
            ->where('approved', true)
            ->latest('updated_at')
            ->paginate(25);

        return $query;
    }

    public function getAll()
    {
        $query = CommunityLink::where('approved', true)
            ->latest('updated_at')
            ->paginate(25);

        return $query;
    }

    public function getMostPopular()
    {
        // Se hace un count de los links que han sido votados por usuarios
        $query = CommunityLink::withCount('users')
            ->where('approved', true)
            // '{relation}_count' es creado por defecto al usar el metodo withCount()
            ->orderBy('users_count', 'desc')
            ->latest('updated_at')
            ->paginate(25);

        return $query;
    }

    public function getMostPopularByChannel(Channel $channel)
    {
        // Filtra los links por el count de votos
        $query = $channel->communityLinks()
            ->withCount('users')
            ->where('approved', true)
            ->orderBy('users_count', 'desc')
            ->latest('updated_at')
            ->paginate(25);

        return $query;
    }
}
