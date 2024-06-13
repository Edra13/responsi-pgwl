<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Points;

class PointController extends Controller
{
    public function __construct()
    {
        $this->point = new Points();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //menampilkan seluruh data yang ada di table point (all)
        // memanggil function points di model
        $points = $this->point->points();

        // dd untuk mengecek data (debug and die)
        // dd($points);

        //json_decode = mengubah string JSON menjadi bentuk Array PHP agar mudah dibaca
        foreach ($points as $p) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id'=> $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'image' => $p->image,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at
                ]
            ];
        }

        //mengembalikan respon menjadi format point JSON
        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $feature,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate Request
        $request->validate([
            'name' => 'required',
            'geom' => 'required',
            'image' => 'mimes:jpg,jpeg,png,gif |max:10000' // > satuan default kilobyte 10MB = 10.000 KB
        ], 
        [
            'name.required' => 'Point name is required',
            'geom.required' => 'Location is required',
            'image.mimes' => 'Image must be jpg, jpeg, png, gif and not be larger than 10MB',
        ]);

        // Create folder images > mk = make directory 
        // kalau tidak ada folder images, maka akan dibuat folder baru dengan permission 0777
        if (!is_dir('storage/images')) {
            mkdir('storage/images', 0777);
        }

        // upload image 
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_point.' . $image->getClientOriginalExtension();
            $image->move('storage/images', $filename);
        } else {
            $filename = null;
        }

        // Store Data
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'geom' => $request->geom,
            'image' => $filename
        ];  


        // Create Point 
        // ! = jika create point gagal, akan dikembalikan ke halaman sebelumnya dengan status error dan message
        if (!$this->point->create($data)) {
            return redirect()->back()->with('error', 'Lengkapi kembali laporan anda!');
        }

        // Redirect To Map
        // Jika sukses..
        return redirect()->back()->with('success', 'Laporan anda sudah diterima, petugas berwenang akan segera menanganinya!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //menampilkan seluruh data yang ada di table point (all)
        // memanggil function point di model
        $point = $this->point->point($id);

        // dd untuk mengecek data (debug and die)
        // dd($points);

        //json_decode = mengubah string JSON menjadi bentuk Array PHP agar mudah dibaca
        foreach ($point as $p) {
            $feature[] = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id'=> $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'image' => $p->image,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at
                ]
            ];
        }

        //mengembalikan respon menjadi format point JSON
        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $feature,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $point = $this->point->find($id);

        $data = [
            'title' => 'Edit Point',
            'point' => $point,
            'id' => $id
        ];

        return view('edit-point', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate Request
        $request->validate([
            'name' => 'required',
            'geom' => 'required',
            'image' => 'mimes:jpg,jpeg,png,gif |max:10000' // > satuan default kilobyte 10MB = 10.000 KB
        ], 
        [
            'name.required' => 'Point name is required',
            'geom.required' => 'Location is required',
            'image.mimes' => 'Image must be jpg, jpeg, png, gif and not be larger than 10MB',
        ]);

        // Create folder images > mk = make directory 
        // kalau tidak ada folder images, maka akan dibuat folder baru dengan permission 0777
        if (!is_dir('storage/images')) {
            mkdir('storage/images', 0777);
        }

        // upload image 
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_point.' . $image->getClientOriginalExtension();
            $image->move('storage/images', $filename);

            // delete old image
            $image_old =  $request->image_old;
            if ($image_old !=null) {
                unlink('storage/images/' . $image_old);
            }

        } else {
            $filename = $request->image_old;
        }

        // Store Data
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'geom' => $request->geom,
            'image' => $filename
        ];  


        // Update Point 
        if (!$this->point->find($id)->update($data)) {
            return redirect()->back()->with('error', 'Laporan gagal diperbarui');
        }

        // Redirect To Map
        // Jika sukses..
        return redirect()->back()->with('success', 'Laporan berhasil diperbarui!');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //get image
        $image = $this->point->find($id)->image;

        // dd($image);
        

        //delete point
        if (!$this->point->destroy($id)) {
            return redirect()->back()->with('error', 'Failed to delete point');
        }

        //delete image
        if ($image != null) {
            unlink('storage/images/' . $image);
        }

        // Redirect To Map jika sukses
        return redirect()->back()->with('success', 'Point deleted successfully');
    }

    public function table()
    {
        $points = $this->point->points();

        $data =[
            'title' => 'Table Point',
            'points' => $points
        ];

        return view('table-point', $data);
    }   

}
