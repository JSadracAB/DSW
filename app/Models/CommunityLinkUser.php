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
        $vote = $this->firstOrNew([
            'user_id' => Auth::id(),
            'community_link_id' => $link->id
        ]);

        if ($vote->id) {
            $vote->delete();
        } else {
            $vote->save();
        }
    }
}
