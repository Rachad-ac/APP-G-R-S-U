<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = [
        'id_role',
        'name_role'
   ];

   public function User()
   {
        return $this->hasMany(User::class, 'id_role');
   }
}
