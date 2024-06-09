<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Security\Service\MenuService;
use App\Http\Controllers\Security\Service\RoleService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $MenuManajemen;
    private $Role;

    public function __construct(MenuService $MenuService, )
    {
        $this->MenuManajemen = $MenuService;
        $role = $userContext->role;
    }

    public function access()
    {
        $userContext = auth()->user();
        if ($role->code == 'super_admin') {
            $MenuList = $this->MenuManajemen->findAll();
            return view('Menu.index', compact('MenuList'));
        }
    }

    public function editAccess()
    {
        $userContext = auth()->user();
        if ($role->code == 'super_admin') {
            return view('Menu.create', compact('MenuList'));
        }
    }

    public function edit()
    {
        $userContext = auth()->user();
        if ($role->code == 'super_admin') {
            return view('Menu.edit', compact('MenuList'));
        }
    }

    public function store(Request $request)
    {
        $userContext = auth()->user();
        $this->validate([
            "request.code" => 'required|max:18',
            "request.name" => 'required',
            "request.description" => 'required',
            "request.parent_code" => 'required',
        ]);
        return redirect()->route('/user/admin_sijupri');
    }

    public function update(Request $request)
    {
    }

    public function delete()
    {
    }
}
