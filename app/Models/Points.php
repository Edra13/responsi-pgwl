<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;

    protected $table = 'table_points';

    //Tabel yang boleh diisikan
    // protected $fillable = ['name', 'description', 'geom', 'image'];

    //Tabel yang tidak boleh diisikan
    protected $guarded = ['id'];

    public function points()
    {
        return $this->select(DB::raw('id, name, description, image, 
        st_asgeojson(geom) as geom, created_at, updated_at'))->get();
}
    public function point($id)
    {
        return $this->select(DB::raw('id, name, description, image, 
        st_asgeojson(geom) as geom, created_at, updated_at'))->where('id', $id)->get();
}

}

