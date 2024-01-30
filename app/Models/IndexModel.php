<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexModel extends Model
{
    use HasFactory;
    protected $table = 'index';

    public function berita()
    {
        return $this->belongsTo(BeritaModel::class, 'berita_id', 'id');
    }
}
