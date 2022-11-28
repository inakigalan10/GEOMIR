<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use \Backpack\CRUD\app\Models\Traits\CrudTrait;


class Post extends Model
{
  
    use HasFactory, CrudTrait;
    protected $fillable = [
        'body',
        'file_id',
        'latitude',
        'longitude',
        'author_id',
        'visibility_id'
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
    public function visibility()
    {
        return $this-> belongsTo(Visibility::class);
    }
    public function liked()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function comprobar_like (){
        $id_post= $this->id;
        $id_user = auth()->user()->id;
        $select = "SELECT id FROM likes WHERE id_post = $id_post and id_user = $id_user";
        $id_like  = DB::select($select);
        return empty($id_like);
    }
    public function contador_like(){
       return DB::table('likes')->where(['id_post'=>$this->id])->count();
    }
}
