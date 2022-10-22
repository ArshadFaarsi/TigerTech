<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [ ];

   /**
    * Get the user that owns the Role
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
 /**
  * The users that belong to the Role
  *
  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
  */
 public function users()
 {
     return $this->belongsToMany(User::class, 'role_users', 'user_id', 'role_id');
 }
}
