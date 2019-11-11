@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
<div class="col-md-12">
{!! Form::open(['url' => 'book', 'method'=>'get', 'class'=>'forminline'])!!}
<div class="form-group {!! $errors->has('q') ? 'has-error' : '' !!}">
{!! Form::text('q', isset($q) ? $q : null, ['class'=>'form-control','placeholder' => 'Judul Buku..']) !!}
{!! $errors->first('q', '<p class="help-block">:message</p>') !!}
</div>
{!! Form::submit('Search', ['class'=>'btn btn-primary']) !!}
{!! Form::close() !!}
<br>
<h3>Data Produk <small><a href="{{ route('book.create') }}"
class="btn btn-warning btn-sm">New Book</a></small></h3>
<table class="table table-hover">
<thead>
<tr>
<td>Judul</td>
<td>Penulis</td>
<td>Harga</td>
<td>ISBN</td>
<td>Jenis Buku</td>
<td>Aksi</td>
</tr>
</thead>
<tbody>
@foreach($book as $books)
<tr>
<td>{{ $books->title }}</td>
<td>{{ $books->writer }}</td>
<td>{{ $books->price }}</td>
<td>{{ !empty($books->isbn->no_isbn) ? $books->isbn->no_isbn : '-'}}</td>
<td>{{ $books->jenis->jenis_buku }}</td>
<td>{!! Form::model($books, ['route' => ['book.destroy', $books],'method' => 'delete', 'class' => 'form-inline'] ) !!}
<a href="{{ route('book.show', $books->id)}}" class="btn btn-success btn-sm">Detail</a> &nbsp;
<a href="{{ route('book.edit', $books->id)}}" class="btn btn-warning btn-sm">Edit</a> &nbsp;
{!! Form::submit('Delete', ['class'=>'btn btn-danger btn-sm']) !!} </td>
{!! Form::close()!!}
</tr>
@endforeach
</tbody>
</table>
{{ $book->appends(compact('q'))->links() }} 
</div>
</div>
</div>
@endsection