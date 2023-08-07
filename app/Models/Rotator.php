<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rotator extends Model
{
    use HasFactory;

    protected $fillable = ['link_id', 'urutan', 'name', 'phone', 'status'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
