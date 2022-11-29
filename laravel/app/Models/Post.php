<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;
    protected $fillable = [
        'body',
        'file_id',
        'latitude',
        'longitude',
        'visibility_id',
        'author_id',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
    // foreign key does not follow conventions!!!
    return $this->belongsTo(User::class, 'author_id');
    }

    public function file()
    {
    return $this->belongsTo(File::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function liked()
    {
    return $this->belongsToMany(User::class, 'likes');
    }

    public function likes()
    {
        return $this->hasMany(Likes::class);
    }
    
}