<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CommunityLinkUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'community_link_id'
    ];

    public function toggle($link)
    {
        // Busca el primer modelo que coincida con las restricciones
        $vote = $this->firstOrNew([
            'user_id' => Auth::id(),
            'community_link_id' => $link->id
        ]);

        // Si existe, lo borra (1 voto menos)
        if ($vote->id) {
            $vote->delete();

        // Si no, lo crea (1 voto más)
        } else {
            $vote->save();
        }
    }
}
