<?php

namespace App\Http\Controllers\Security;

use App\Enums\RoleCode;
use App\Enums\UserStatus;
use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Security\Service\UserService;
use App\Http\Controllers\Ukom\Service\UkomPeriodeService;
use App\Models\Audit\AuditLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        if (!$this->verifyCaptcha($request)->json()['success']) {
            return redirect()->back()->withInput()->withErrors(['captcha' => 'Please verify that you are not a robot.']);
        }

        $user = new UserService();
        $user = $user->findById($request->nip);

        if (in_array($user->user_status, [UserStatus::ACTIVE, UserStatus::NOT_ACTIVE])) {
            if (Hash::check($request->password, Crypt::decrypt($user->password))) {
                return DB::transaction(function () use ($request, $user) {
                    Auth::login($user);

                    $periodeUkom = new UkomPeriodeService();
                    $periodeUkom = $periodeUkom->findPengunguman();

                    session()->forget('periode');

                    if (isset($periodeUkom)) {
                        session()->put('periode', '/ukom/pengumuman/' . $periodeUkom->pengumuman_id);
                    }
                    if ($request->nip == $request->password) {
                        return view('password');
                    }
                    if (Auth::user()->role->base == RoleCode::USER) {
                        if (isset($periodeUkom)) {
                            if ($periodeUkom->hasil == 1) {
                                session()->put('periode', null);
                                session()->put('hasil', '/ukom/hasil/' . auth()->user()->nip);
                            }
                        }
                    }

                    $authLogin = AuditLogin::create([
                        'nip' => $user->nip,
                        'ip_address' => $request->ip_address ?? '',
                        'user_agent' => $request->user_agent ?? '',
                        'tgl_login' => now(),
                    ]);
                    Session::put("($authLogin->nip)_id", $authLogin->id);
                    Cache::forget('menu_data_' . $authLogin->nip);

                    return redirect()->route('/dashboard');
                });
            } else {
                Session::flash('status', 1);
                return redirect()->route('login');
            }
        } else {
            throw new BusinessException([
                "message" => "User Status Tidak Ditemukan",
                "error code" => "SEC-000002",
                "code" => 500
            ], 500);
        }
    }

    public function logout()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            if (Session::has("($userContext->nip)_id")) {
                $authLogin = AuditLogin::where('id', Session::get("($userContext->nip)_id"))->first();
                if ($authLogin) {
                    $authLogin->tgl_logout = now();
                    $authLogin->save();
                    Session::forget("($authLogin->nip)_id");
                }
            }

            Cache::forget('menu_data_' . $userContext->nip);
            Auth::logout();
        });
        return redirect()->route('login');
    }

    private function changePassword()
    {
        return view('password');
    }

    public function password_update(Request $request)
    {
        $userContext = auth()->user();

        $user = new UserService();
        $user = $user->findById($userContext->nip);
        $user->password = $request['password'];
        $user->customUpdate();

        Session::flash('status', '1');
        return redirect()->route('login');
    }

    private function verifyCaptcha($request)
    {
        return Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('CAPTCHA_SECRET_KEY', ''),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);
    }
}
