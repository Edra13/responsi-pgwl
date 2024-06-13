@extends('layouts.template')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header" >
            <h3>Polygon Data</h3>
            </div>
            <div class="card-body">
            <table id="example" class="table table-bordered table-striped">
<thead>
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Description</th>
        <th>Image</th>
        <th>Created at</th>
    </tr>
</thead>
<tbody>
    @php $no = 1 @endphp
    @foreach ($polygons as $p)

    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $p->name }}</td>
        <td>{{ $p->description }}</td>
        <td>
            <img src="{{ asset('storage/images/'.$p->image) }}"  class="center-image" alt="" width="200">
        </td>
        @if ($p->created_at)
        <td>{{ date_format($p->created_at, 'D, d-m-Y, H:i:s') }}</td>
        @else
        <td>-</td> <!-- Tampilkan tanda strip atau pesan default jika created_at null -->
        @endif

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
<style>
    .center-image {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
@endsection

@section('script')
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

<script>
    new DataTable('#example');
</script>
@endsection