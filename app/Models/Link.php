<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'type_pixel', 'pixel', 'pesan', 'link', 'link_type', 'jumlah_rotator', 'count_link', 'email', 'status'];

    public function rotator()
    {
        return $this->hasMany(Rotator::class);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setLinkAttribute($value)
    {
        $this->attributes['link'] = Str::slug($value);
    }

    public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge badge-secondary">Draft</span>';
        }
        return '<span class="badge badge-success">Aktif</span>';
    }

    public function getLinkTypeLabelAttribute()
    {
        if ($this->link_type == 0) {
            return '<span class="badge badge-secondary">Single</span>';
        } elseif ($this->link_type == 1) {
            return '<span class="badge badge-success">Berurutan</span>';
        } elseif ($this->link_type == 2) {
            return '<span class="badge badge-success">Random</span>';
        }
    }
}
