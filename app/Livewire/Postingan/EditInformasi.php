<?php

namespace App\Livewire\Postingan;

use App\Models\Berkas;
use App\Models\Kategori;
use App\Models\Postingan;

use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Str;

use Intervention\Image\Laravel\Facades\Image;

class EditInformasi extends Component
{
    use WithFileUploads;

    public $judul = "Edit Informasi";
    public $id;
    public $judul_postingan;
    public $konten;
    public $berkas_id;
    public $url_berkas;
    public $publish = 0;
    public $kategori_postingan = [];

    public $gambar_sampul;

    public function render()
    {
        $kategori = Kategori::orderBy('id', 'ASC')->get();
        return view('livewire.postingan.edit-informasi', ['kategori' => $kategori])
            ->extends('layouts.backend')
            ->section('content');
    }

    public function mount($id)
    {
        $get = Postingan::where('id', $id)->first();
        $this->id = $get->id;
        $this->judul_postingan = $get->judul;
        $this->konten = $get->konten;
        $this->publish = $get->publish;
        $this->url_berkas = $get->banner->url_berkas ?? '';
        $this->kategori_postingan = $get->kategori()->get()->pluck('id')->toArray();
    }

    public function save()
    {
        $rules = [
            'judul_postingan' => 'required|string|max:100',
            'konten' => 'required|string',
            'kategori_postingan' => 'required|array|min:1',
        ];

        // dd($this->gambar_sampul, $rules);

        $this->validate($rules);

        $data = [
            'judul' => $this->judul_postingan,
            'konten' => $this->konten,
            'slug' => Str::slug($this->judul_postingan),
            'publish' => $this->publish,
        ];

        $posting = Postingan::where('id', $this->id)->first();
        $posting->kategori()->sync([]);
        $posting->update($data);
        $posting->kategori()->sync($this->kategori_postingan);

        alert()->success('Success', 'Informasi berhasil di edit');
        return $this->redirect(route('admin.informasi'));
    }

    public function gantibanner($id)
    {
        $get = Postingan::where('id', $id)->first();
        $this->id = $get->id;
        $this->berkas_id = $get->berkas_id;
        $this->url_berkas = $get->banner->url_berkas ?? '';

        // dd($get);
        $this->dispatch('open-modal');
    }

    public function act_gantibanner()
    {
        $this->validate([
            'gambar_sampul' => 'required|image|mimes:jpg,jpeg|max:1024'
        ]);

        $berkas_id = $this->berkas_id;
        $url_berkas = $this->url_berkas;

        if (file_exists($url_berkas)) {
            // dd($url_berkas);
            unlink($url_berkas);
        }

        // dd($berkas_id, $url_berkas);

        $image = $this->gambar_sampul;

        $nama_file = time() . '.' . $image->getClientOriginalExtension();
        $ukuran_file = $image->getSize();
        $lokasi_file = public_path('/storage/postingan/');

        $img = Image::read($image->path());
        $img->resize(1024, 768, function ($constraint) {
            $constraint->aspectRatio();
        })->save($lokasi_file . $nama_file);

        Berkas::where('id', $berkas_id)->update([
            'name_berkas' => $nama_file,
            'path_berkas' => 'storage/postingan/',
            'url_berkas' => 'storage/postingan/' . $nama_file,
            'type_berkas' => $image->getClientOriginalExtension(),
            'size_berkas' => $ukuran_file,
            'penyimpanan' => 'local'
        ]);

        // alert()->success('Success', 'Berhasil ganti banner informasi');
        return $this->redirect(route('admin.informasi.edit', $this->id));
    }

    public function _reset()
    {
        $this->gambar_sampul = NULL;
        $this->resetErrorBag();
        $this->dispatch('close-modal');
    }
}
