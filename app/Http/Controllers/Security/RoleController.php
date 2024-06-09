<?php

namespace App\Http\Controllers\Security;

use App\Enums\RoleCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Security\Service\RoleService;
use App\Http\Controllers\Security\Service\MenuService;
use App\Models\Audit\AuditLogin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{

    private $role;

    public function __construct(RoleService $role)
    {
        $this->role = $role;
    }

    public function index()
    {
        $roleList = $this->role->findByRoleBase(RoleCode::ADMIN_SIJUPRI);
        return view('security.role', compact('roleList'));
    }

    public function detail($code)
    {
        $roleData = $this->role->findById($code);

        $menus = DB::table('tbl_menu')
            ->select('tbl_menu.parent_code', 'tbl_menu.lvl', 'tbl_menu.name', 'tbl_menu.code', 'tbl_role_menu.role_code')
            ->leftJoin('tbl_role_menu', function ($join) use ($code) {
                $join->on('tbl_role_menu.menu_code', '=', 'tbl_menu.code')
                    ->where('tbl_role_menu.role_code', '=', $code);
            })
            ->where('tbl_menu.app_code', 'like', '%PUSBIN%')
            ->orderBy('tbl_menu.idx', 'ASC')
            ->orderBy('tbl_menu.lvl', 'ASC')
            ->get();

        $groupedMenus = $menus->groupBy('parent_code');

        $buildMenuHierarchy = function ($parentCode) use ($groupedMenus, &$buildMenuHierarchy) {
            $result = new Collection();

            if (isset($groupedMenus[$parentCode])) {
                foreach ($groupedMenus[$parentCode] as $menu) {
                    $menu->children = $buildMenuHierarchy($menu->code);
                    $result->push($menu);
                }
            }

            return $result;
        };

        $menuHierarchy = $buildMenuHierarchy(null);

        return view('security.role_detail', compact(
            'roleData',
            'menuHierarchy'
        ));
    }

    public function edit(Request $request)
    {
        $userContext = auth()->user();

        $role = new RoleService();
        $role = $role->findById($request->code);
        $role->updateRoleMenu($request['roleMenu']);

        if ($userContext->role_code === $request->code) {
            DB::transaction(function () {
                $userContext = auth()->user();

                if (Session::has("($userContext->nip)_id")) {
                    $authLogin = AuditLogin::where('id', Session::get("($userContext->nip)_id"))->first();
                    if ($authLogin) {
                        $authLogin->tgl_logout = now();
                        $authLogin->save();
                    }
                }
            });
            Cache::forget('menu_data_' . $userContext->nip);
            Auth::logout();
            return redirect()->route('login');
        }

        return redirect()->back();
    }
}
