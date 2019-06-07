<?php

namespace blo;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
      return $this->belongsTo('blo\User');
    }
}
