<?php

namespace App\Livewire\Pesertaukt;

use App\Models\Berkas;
use App\Models\Pesertaukt;
use App\Models\PesertauktDokumen;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class UploadBuktiDukung extends Component
{
    use WithFileUploads;

    public $file_upload;
    public $detail;
    public $urutan;
    public $dokumen;
    public $dokumen_old;

    public function render()
    {
        return view('livewire.pesertaukt.upload-bukti-dukung');
    }

    public function save()
    {
        $rules = [
            'file_upload' => ['required', File::types(['pdf', 'jpg', 'jpeg'])->max(1 * 1024)]
        ];
        $this->validate($rules, [
            'file_upload.required' => 'File belum anda pilih!',
            'file_upload.mimes' => 'File yang dijinkan *pdf, *jpg, *jpeg',
            'file_upload.max' => 'Maksimal ukuran file 1MB'
        ]);
        // dd($this);

        $nama_lengkap = auth()->user()->name;
        $berkas = new Berkas();

        $file = $this->file_upload;
        $nama_file = time() . '-' . Str::slug(strtolower($nama_lengkap)) . '.' . $file->getClientOriginalExtension();
        $ukuran_file = $file->getSize();
        $path = date('Y') . '/' . $this->dokumen . '/';

        // proses delete
        if (trim($this->dokumen_old)) {
            $dokumen_old = decode_arr($this->dokumen_old);
            $get = $berkas->find($dokumen_old['berkas_id']);
            if ($get) {
                // delete file s3
                Storage::disk('s3')->delete($get->path_berkas . $get->name_berkas);

                // delete row di tabel master_berkas
                $berkas->hapus($dokumen_old['berkas_id']);
            }
        }

        // proses upload
        Storage::disk('s3')->put($path . $nama_file, file_get_contents($file->getRealPath()), 'public');
        $url_file = Storage::disk('s3')->url($path . $nama_file);

        // remove file local after upload s3 
        if (file_exists($file->getRealPath())) {
            unlink($file->getRealPath());
        }

        $berkas = $berkas->create([
            'name_berkas' => $nama_file,
            'path_berkas' => $path,
            'url_berkas' => $url_file,
            'type_berkas' => $file->getClientOriginalExtension(),
            'size_berkas' => $ukuran_file,
            'penyimpanan' => 'cloud',
        ]);

        if (!trim($this->dokumen_old)) {
            PesertauktDokumen::create([
                'peserta_id' => session('peserta_id'),
                'urutan' => $this->urutan,
                'dokumen' => $this->dokumen,
                'berkas_id' => $berkas->id
            ]);
        } else {
            $dokumen_old = decode_arr($this->dokumen_old);
            PesertauktDokumen::where('id', $dokumen_old['id'])->update(['berkas_id' => $berkas->id]);
        }

        Pesertaukt::where('id', session('peserta_id'))->update([
            'status' => 2
        ]);
        alert()->success('Success', 'Berkas Dukung Berhasil Diupload.');
        return $this->redirect(route('peserta.berkasdukung'));
    }

    #[On('modal-open')]
    public function modal_open($detail, $urutan, $dokumen, $dokumen_old)
    {
        $this->resetErrorBag();
        $this->detail = $detail;
        $this->urutan = $urutan;
        $this->dokumen = $dokumen;
        $this->dokumen_old = $dokumen_old;
        $this->dispatch('open-modal');
        // dd($urutan, $dokumen, $dokumen_old);
    }

    public function _reset()
    {
        $this->resetErrorBag();
        $this->file_upload = "";
        $this->detail = "";
        $this->urutan = "";
        $this->dokumen = "";
        $this->dokumen_old = "";
        $this->dispatch('close-modal');
    }
}
