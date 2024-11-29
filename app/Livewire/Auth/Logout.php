<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Logout extends Component
{
    public $tampilan;
    public function mount($tampilan = 'logout1')
    {
        $this->tampilan = $tampilan;
    }

    public function render()
    {
        if ($this->tampilan == 'logout1') {
            return view('livewire.auth.logout1');
        } else {
            return view('livewire.auth.logout2');
        }
    }

    public function _logout()
    {
        if (!Auth::check()) {
            flash('danger', 'Session telah berakhir, silahkan anda login!');
            return $this->redirect(route('auth.login'));
        }

        session()->flush();
        Auth::logout();
        Cache::flush();

        // alert()->success('Success', 'Anda telah logout dari sistem!');
        flash('success', 'Anda telah logout dari sistem!');
        return $this->redirect(route('auth.login'));
    }
}
