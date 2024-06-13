<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polylines extends Model
{
    use HasFactory;

    // 1 model 1 database > berinteraksi dengan database
    protected $table = 'table_polylines';

    // Yang tidak boleh diubah hanya id > kolom lain dapat diubah
    protected $guarded = ['id'];

    public function polylines()
    {
        return $this->select(DB::raw('id, name, description, image, 
        st_asgeojson(geom) as geom, created_at, updated_at'))->get();
}
    public function polyline($id)
    {
        return $this->select(DB::raw('id, name, description, image, 
        st_asgeojson(geom) as geom, created_at, updated_at'))->where('id', $id)->get();
}

}
