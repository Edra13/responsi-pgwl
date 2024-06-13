@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white" >
            <h4>Laporan Gangguan Lalu Lintas</h4>
            </div>
            <div class="card-body">
            <table id="example" class="table table-bordered table-striped">
<thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Gangguan Lalu Lintas</th>
        <th class="text-center">Detail Kejadian</th>
        <th class="text-center">Koordinat Lokasi</th>
        <th class="text-center">Foto</th>
        <th class="text-center">Waktu Pembuatan Laporan</th>
    </tr>
</thead>
<tbody>
    @php $no = 1 @endphp
    @foreach ($points as $p)

    @php
    $geometry = json_decode($p->geom);
    @endphp
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $p->name }}</td>
        <td>{{ $p->description }}</td>
        <td>{{ $geometry->coordinates[0] . ', ' . $geometry->coordinates[1] }}</td>
        <td>
            <img src="{{ asset('storage/images/'.$p->image) }}"  alt="" width="200">
        </td>
        <td>{{ date_format ($p->created_at, 'D, d-m-Y, H:i:s')}}</td>
    </tr>
    @endforeach
</tbody>
</table>
            </div>
    </div>
</div>
@endsection 

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
@endsection

@section('script')
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

<script>
    new DataTable('#example');
</script>
@endsection

