@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover">
                <tr>
                    <th>Judul</th>
                    <td>{{ $book->title }}</td>
                </tr>
                <tr>
                    <th>Penulis</th>
                    <td>{{ $book->writer }}</td>
                </tr>
                <tr>
                    <th>Ringkasan</th>
                    <td>{{ $book->summary }}</td>
                </tr>
                <tr>
                    <th>Harga</th>
                    <td>{{ $book->price }}</td>
                </tr>
                <tr>
                    <th>No ISBN</th>
                    <td>{{ !empty($book->isbn->no_isbn) ? $book->isbn->no_isbn : '-'}}</td>
                </tr>
                <tr>
                    <th>Jenis Buku</th>
                    <td>{{ $book->jenis->jenis_buku }}</td>
                </tr>
                    <th>Identitas Buku</th>
                    <td>
                    @foreach($book->identity as $item)
                    <strong>{{ $item->nama_identity }}</strong>,
                    @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Foto</th>
                    <td>
                    <img src="{{ url('/img/' . $book->photo) }}" class="img-rounded">
                    </td>
                </tr>
                <tr>
                    <td colspan=2><a href="{{ route('book.index')}}" class="btn btn-success btn-sm">Back</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection