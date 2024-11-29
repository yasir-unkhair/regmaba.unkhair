<?php

use App\Models\Referensi;
use App\Models\Setup;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

if (!function_exists('flash')) {
    function flash($type, $message)
    {
        Session::flash('flash', $type . '|' . $message);
    }
}

if (!function_exists('flashAllert')) {
    /***
     * cara menggunakan
     * Redirect::back()->with('message', 'error|There was an error...');
     * Redirect::back()->with('message', 'message|Record updated.');
     * Redirect::to('/')->with('message', 'success|Record updated.');
     * cara panggil 
     * {{ displayAlert() }}
     */
    function flashAllert()
    {
        if (Session::has('flash')) {
            list($type, $message) = explode('|', Session::get('flash'));
            $type = ($type == 'error') ? 'danger' : $type;

            $icon = '';
            if ($type == 'danger') {
                $icon = 'fa-ban';
            } elseif ($type == 'info') {
                $icon = 'fa-info';
            } elseif ($type == 'warning') {
                $icon = 'fa-exclamation-triangle';
            } elseif ($type == 'success') {
                $icon = 'fa-check';
            }

            $flash = '
            <div class="alert alert-' . $type . ' alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b><i class="fa ' . $icon . '"></i> Alert!</b><br>
                ' . $message . '
            </div>
            ';
            return $flash;
        }

        return '';
    }
}

if (!function_exists('pengaturan')) {
    function pengaturan($id = NULL)
    {
        $expire = Carbon::now()->addMinutes(300); // 5 menit
        $pengaturan = Cache::remember('app_pengaturan', $expire, function () use ($id) {
            $select = DB::table('app_pengaturan')->select(['id', 'value'])->get()->toArray();
            $pengaturan = Arr::mapWithKeys($select, function ($item) {
                return [$item->id => $item->value];
            });
            return $pengaturan;
        });

        if ($id && is_string($id)) {
            if (array_key_exists($id, $pengaturan)) {
                return $pengaturan[$id];
            }
            return '';
        } else {
            return $pengaturan;
        }
    }
}


if (!function_exists('get_setup')) {
    function get_setup(array $kolom = ['*'])
    {
        return Setup::where('aktif', 'Y')->select($kolom)->first();
    }
}

if (!function_exists('master_referensi')) {
    function master_referensi($referensi)
    {
        $ref = Referensi::with('subReferensi')->where('referensi', $referensi)->first();
        return $ref->subReferensi()->where(['aktif' => 'Y'])->orderBy('created_at', 'ASC')->get();
    }
}

if (!function_exists('get_referensi')) {
    function get_referensi($id)
    {
        if (!trim($id)) {
            return '';
        }

        $get = Referensi::where('id', $id)->select(['referensi'])->first();
        if ($get) {
            return $get->referensi;
        }
        return '';
    }
}

if (!function_exists('randomString')) {
    function randomString($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}


if (!function_exists('get_token')) {
    function get_token()
    {
        $pengaturan = pengaturan();
        $username_admin = $pengaturan['username-admin'];
        $password_admin = $pengaturan['password-admin'];
        $url_simak = $pengaturan['url-simak'];

        $response  = post_data($url_simak . '/apiv2/index.php/token', ['username' => $username_admin, 'password' => $password_admin]);
        return json_decode($response, true);
    }
}

if (!function_exists('post_data')) {
    function post_data($url, $data)
    {
        $useragent = 'PHP Client 1.0 (curl) ' . phpversion();  // set user agent
        $ch = curl_init(); // persiapkan curl
        curl_setopt($ch, CURLOPT_URL, $url); // set url 
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //post data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return data trasnfer 
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent); //panggil useragent
        $output = curl_exec($ch); //output ke string
        curl_close($ch); // tutup curl 
        return $output; // mengembalikan hasil curl
    }
}

if (!function_exists('get_data')) {
    function get_data($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        if (!empty(curl_error($ch))) {
            $result = print_r(curl_error($ch) . ' - ' . $url);
        }
        curl_close($ch);
        return $result;
    }
}

if (!function_exists('str_curl')) {
    function str_curl($url, $data)
    {
        return $url . '?' . http_build_query($data);
    }
}

if (!function_exists('routeIs')) {
    function routeIs($route = NULL)
    {
        $routeName = Route::currentRouteName();
        if ($route) {
            if (is_array($route)) {
                return in_array($routeName, $route) ? TRUE : FALSE;
            } else {
                return $routeName == $route ? TRUE : FALSE;
            }
        }
        return $routeName;
    }
}


if (!function_exists('encode_arr')) {
    function encode_arr($data)
    {
        if (!array_key_exists('time', $data)) {
            $data += ['time' => time()];
        }

        return encryptor('encrypt', json_encode($data));
    }
}

if (!function_exists('decode_arr')) {
    function decode_arr($data)
    {
        return json_decode(encryptor('descrypt', $data), TRUE);
    }
}

if (!function_exists('encryptor')) {
    function encryptor($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";

        $secret_key = "un1v3RS1T45Kh41Run";
        $secret_iv  = "Unkhair!!@@##";

        $key = hash('sha256', $secret_key);
        $iv  = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'descrypt') {
            $output = base64_decode($string);
            $output = openssl_decrypt($output, $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
}

if (!function_exists('data_params')) {
    function data_params($params, $key)
    {
        $arr = decode_arr($params);
        if (!$arr) {
            return NULL;
        }

        return array_key_exists($key, $arr) ? $arr[$key] : NULL;
    }
}

if (!function_exists('listRekomendasi')) {
    function listRekomendasi($field, $key = NULL)
    {
        $type = DB::select(DB::raw('SHOW COLUMNS FROM app_peserta_has_verifikasiberkas WHERE Field = "' . $field . '"')->getValue(DB::connection()->getQueryGrammar()))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach (explode(',', $matches[1]) as $value) {
            $data = trim($value, "'");
            $values[] = $data;
        }

        if ($key) {
            $valueOne = [];
            foreach ($values as $row) {
                if ($row == $key) {
                    $valueOne[] = $row;
                }
            }
            return $valueOne;
        }

        return $values;
    }
}
if (!function_exists('rupiah')) {
    function rupiah($nilai, $format = TRUE)
    {
        if (!$nilai) {
            return '0';
        }

        if (!$format) {
            return preg_replace("/[^0-9]/", "", $nilai);
        }

        return number_format($nilai, 0, ',', '.');
    }
}
