<?php

namespace App\Http\Controllers;
use App\Book;   //ini yang ditambahin
use Illuminate\Http\Request;
use Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use File;
use App\Isbn;
use App\Jenis;
use App\Identity;

class BookProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $book = Book::where('title', 'LIKE', '%'.$q.'%')->orderBy('title')->paginate(5);
        return view('product.index', compact('book', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dataJenisBuku = Jenis::pluck('jenis_buku','id');
        $list_identity = Identity::pluck('nama_identity','id');
        return view('product.create', compact('dataJenisBuku', 'list_identity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'writer' => 'required|string|max:255',
            'summary' => 'required|string',
            'price' => 'sometimes|numeric',
            'no_isbn' => 'required|string|max:255',
            'id_jenis' => 'required',
            'identity' => 'required',
            'photo' => 'mimes:jpeg,png|max:10240'
            ]);
            $data = $request->only('title', 'writer', 'summary','price','no_isbn','id_jenis','identity');
            if ($request->hasFile('photo'))
            {
                $data['photo'] = $this->savePhoto($request->file('photo'));
            }
            //Book::create($data);
            $post = Book::create($data);
            $post->identity()->attach($request->input(‘identity’));
            $isbn = new Isbn;
            $isbn->no_isbn = $request->input('no_isbn');
            $post->isbn()->save($isbn);

            return redirect()->route('book.index')->with('success', 'Berhasil Menyimpan Judul Buku : '.$request->get('title'));  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('product.detail', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $book->no_isbn = $book->isbn->no_isbn;
        $dataJenisBuku = Jenis::pluck('jenis_buku','id');
        $list_identity = Identity::pluck('nama_identity','id');
        return view('product.edit', compact('book','dataJenisBuku','list_identity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $this->validate($request, [
        'title' => 'required|string|max:255,' . $book->id,
        'writer' => 'required|string|max:255,' . $book->id,
        'summary' => 'required|string|max:255,' . $book->id,
        'no_isbn' => 'required|string|max:255,' . $book->id,
        'id_jenis' => 'required',
        'identity' => 'required',
        'photo' => 'mimes:jpeg,png|max:10240',
        ]);
        $data = $request->only('title', 'writer', 'summary', 'price', 'id_jenis', 'identity');
        if ($request->hasFile('photo'))
        {
            $data['photo'] = $this->savePhoto($request->file('photo'));
            if ($book->photo !== '') $this->deletePhoto($book->photo);
        }
        $book->update($data);
        $isbn = $book->isbn;
        $isbn->no_isbn = $request->input('no_isbn');
        $book->isbn()->save($isbn);
        $book->identity()->sync($request->input('identity'));
        return redirect()->route('book.index')->with('success', 'Berhasil Update Judul Buku : '.$request->get('title'));        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Book::find($id)->delete();
        //return redirect()->route('book.index')->with('error', 'Berhasil Hapus Buku !!');
        //return redirect()->route('book.index');

        $book = Book::find($id);
        if ($book->photo !== '') $this->deletePhoto($book->photo);
        $book->delete();
        return redirect()->route('book.index')->with('error', 'Berhasil Hapus Buku !!');
        return redirect()->route('book.index');

    }

    protected function savePhoto(UploadedFile $photo)
    {
        $fileName = str_random(40) . '.' . $photo->guessClientExtension();
        $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
        $photo->move($destinationPath, $fileName);
        return $fileName;
    }

    public function deletePhoto($filename)
    {
        $path = public_path() . DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . $filename;
        return File::delete($path);
    }

}
