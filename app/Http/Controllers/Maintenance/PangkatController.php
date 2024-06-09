<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Service\PangkatService;
use Illuminate\Http\Request;

class PangkatController extends Controller
{
    private $pangkat;

    public function __construct(PangkatService $pangkatService)
    {
        $this->pangkat = $pangkatService;
    }

    public function index()
    {
        $pangkatList = $this->pangkat->findAll();
        return view('maintenance.pangkat.index', compact('pangkatList'));
    }

    public function create()
    {
    }

    public function edit()
    {
    }

    public function store(Request $request)
    {
    }

    public function update(Request $request)
    {
    }

    public function delete()
    {
    }
}