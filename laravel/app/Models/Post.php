<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Backpack\CRUD\app\Models\Traits\CrudTrait;

class Post extends Model
{
  
    use HasFactory, CrudTrait;
    protected $fillable = [
        'body',
        'file_id',
        'latitude',
        'longitude',
        'author_id'
    ];
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function user()
        {
        // foreign key does not follow conventions!!!
        return $this->belongsTo(User::class, 'author_id');
        }
    public function author()
        {
            return $this->belongsTo(User::class);
        }
     

}
