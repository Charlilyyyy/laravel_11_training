<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'parent_post_id',
        'user_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    public function interactionPlural() {
        return $this->hasMany('App\Models\Interaction', 'post_id');
    }

    public function childPostPlural() {
        return $this->hasMany('App\Models\Post', 'parent_post_id');
    }

    public function parentPostSingular(){
        return $this->belongsTo('App\Models\Post', 'parent_post_id');
    }

    public function UserSingular(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
