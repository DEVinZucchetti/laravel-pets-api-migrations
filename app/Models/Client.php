<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['people_id'];

    public function people(): HasOne
    {
        return $this->hasOne(People::class, 'id', 'people_id');
    }
}
