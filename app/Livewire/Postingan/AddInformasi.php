<?php

namespace App\Livewire\Postingan;

use App\Models\Berkas;
use App\Models\Kategori;
use App\Models\Postingan;
use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class AddInformasi extends Component
{
    use WithFileUploads;

    public $judul = "Tambah Informasi";
    public $judul_postingan;
    public $konten;
    public $berkas_id;
    public $publish = 0;
    public $kategori_postingan = [];

    public $gambar_sampul;

    public function render()
    {
        $kategori = Kategori::orderBy('id', 'ASC')->get();
        return view('livewire.postingan.add-informasi', ['kategori' => $kategori])
            ->extends('layouts.backend')
            ->section('content');
    }

    public function save()
    {
        $this->validate([
            'judul_postingan' => 'required|string|max:100',
            'konten' => 'required|string',
            'kategori_postingan' => 'required|array|min:1',
            'gambar_sampul' => 'required|image|mimes:jpg,jpeg|max:1024'
        ]);

        // dd($this->gambar_sampul, $this->gambar_sampul->getSize());

        $image = $this->gambar_sampul;
        // dd($image->path(), $image->getSize(), $image->getClientOriginalExtension());

        $nama_file = time() . '.' . $image->getClientOriginalExtension();
        $ukuran_file = $image->getSize();
        $lokasi_file = public_path('/storage/postingan/');

        $img = Image::read($image->path());
        $img->resize(1024, 768, function ($constraint) {
            $constraint->aspectRatio();
        })->save($lokasi_file . $nama_file);

        $berkas = Berkas::create([
            'name_berkas' => $nama_file,
            'path_berkas' => 'storage/postingan/',
            'url_berkas' => 'storage/postingan/' . $nama_file,
            'type_berkas' => $image->getClientOriginalExtension(),
            'size_berkas' => $ukuran_file,
            'penyimpanan' => 'local'
        ]);

        $data = [
            'user_id' => auth()->user()->id,
            'judul' => $this->judul_postingan,
            'konten' => $this->konten,
            'slug' => Str::slug($this->judul_postingan),
            'berkas_id' => $berkas->id,
            'publish' => $this->publish,
        ];

        $posting = Postingan::create($data);
        $posting->kategori()->sync($this->kategori_postingan);
        // dd($data, $this->kategori_postingan);
        alert()->success('Success', 'Berhasil membuat informasi');
        return $this->redirect(route('admin.informasi'));
    }
}
