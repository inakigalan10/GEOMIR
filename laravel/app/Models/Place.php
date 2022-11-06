<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function file(){
        return $this->hasOne(File::class);
    }

    public function user(){
        // foreign key does not follow conventions!!!
        return $this->belongsTo(User::class, 'author_id');
    }

}
