<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'channel_id',
        'title',
        'link',
        'approved'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'community_link_users');
    }

    public function hasAlreadyBeenSubmitted($link)
    {

        // Como opcion adicional, incluir que solo se actualize el link 
        // si el usuario en cuestion esta aprobado

        // Si el link existe
        if ($existing = static::where('link', $link)->first() /* && $user->isTrusted() */) {
            // Se actualiza el campo 'update_at'
            $existing->touch();
            $existing->save();
            return true;
        }
        return false;
    }
}
