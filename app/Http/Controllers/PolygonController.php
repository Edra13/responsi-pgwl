<?php

namespace App\Http\Controllers;

use App\Models\Polygon;
use Illuminate\Http\Request;

class PolygonController extends Controller
{
    public function __construct()
    {
        $this->polygon = new Polygon();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polygons = $this->polygon->polygons();
        foreach ($polygons as $p) {
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

        //mengembalikan respon menjadi format polygon JSON
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
        /// Validate Request
        $request->validate([
            'name' => 'required',
            'geom' => 'required',
            'image' => 'mimes:jpg,jpeg,png,gif |max:10000'
        ], 
        [
            'name.required' => 'Polygon name is required',
            'geom.required' => 'Location is required',
            'image.mimes' => 'Image must be jpg, jpeg, png, gif and not be larger than 10MB'
        ]);
       
        if (!is_dir('storage/images')) {
            mkdir('storage/images', 0777);
        }

        // upload image 
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_polygon.' . $image->getClientOriginalExtension();
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


        // Create Polygon
        // ! = jika create polygon gagal, akan dikembalikan ke halaman sebelumnya dengan status error dan message
        if (!$this->polygon->create($data)) {
            return redirect()->back()->with('error', 'Failed to create polygon');
        }

        // Redirect To Map
        // Jika sukses..
        return redirect()->back()->with('success', 'Polygon created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $polygon = $this->polygon->polygon($id);

        foreach ($polygon as $p) {
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

        //mengembalikan respon menjadi format polygon JSON
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
        $polygon = $this->polygon->find($id);

        $data = [
            'title' => 'Edit',
            'polygon' => $polygon,
            'id' => $id
        ];

        return view('edit-polygon', $data);
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
            $filename = time() . '_polygon.' . $image->getClientOriginalExtension();
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
        if (!$this->polygon->find($id)->update($data)) {
            return redirect()->back()->with('error', 'Failed to update polygon');
        }

        // Redirect To Map
        // Jika sukses..
        return redirect()->back()->with('success', 'Point updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         //get image
         $image = $this->polygon->find($id)->image;

         // dd($image);
         
 
         //delete polygon
         if (!$this->polygon->destroy($id)) {
             return redirect()->back()->with('error', 'Failed to delete polygon');
         }
 
         //delete image
         if ($image != null) {
             unlink('storage/images/' . $image);
         }
 
         // Redirect To Map jika sukses
         return redirect()->back()->with('success', 'Polygon deleted successfully');
    }
    public function table()
    {
        $polygons = $this->polygon->polygons();

        $data =[
            'title' => 'Table Polygon',
            'polygons' => $polygons
        ];

        return view('table-polygon', $data);
    }   
}
