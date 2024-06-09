<?php

namespace App\Http\Controllers\Siap;

use App\Enums\RoleCode;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Security\Service\UserService;

class RegistrationController extends Controller
{
    private $user;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $userList = $this->user->findAll();
        return view('siap.registration.index', compact('userList'));
    }

    public function sijupri()
    {
        return view('registration.sijupri');
    }

    public function instansi()
    {
        return view('registration.instansi');
    }

    public function pengelola()
    {
        return view('registration.pengelola');
    }

    public function user()
    {
        return view('registration.user');
    }

    public function create()
    {
        return view('siap.registration.create');
    }
}
