<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'interactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    public function postSingular()
    {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }

    public function UserSingular()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
