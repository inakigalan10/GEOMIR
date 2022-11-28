<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\DB;

class Place extends Model
{
    
    use HasFactory,CrudTrait;
    protected $fillable = [
        'name',
        'description',
        'file_id',
        'latitude',
        'longitude',
        'category_id',
        'visibility_id',
        'author_id',
    ];

    public function file(){
        return $this->belongsTo(File::class);
    }

    public function user(){
        // foreign key does not follow conventions!!!
        return $this->belongsTo(User::class, 'author_id');
    }
    public function author(){
        return $this->belongsTo(User::class);
    }

    public function favorited(){
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function comprobar_favorite(){
        $id_place= $this->id;
        $id_user = auth()->user()->id;
        $select = "SELECT id FROM favorites WHERE id_place = $id_place and id_user = $id_user";
        $id_favorite = DB::select($select);
        return empty($id_favorite);
    }
    public function contador_fav(){
        return DB::table('favorites')->where(['id_place' => $this->id])->count();
    }
}
