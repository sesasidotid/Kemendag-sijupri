<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\MessagingService;
use App\Models\Messaging\Announcement;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{

    public function index()
    {
        $announcementList = Announcement::orderBy('created_at', 'asc')->get();

        return view('pengumuman.daftar', compact(
            'announcementList'
        ));
    }

    public function detail(Request $request)
    {
        $messaging = new MessagingService();

        $announcement = $messaging->findAnnouncementById($request->id);
        $messaging->setAnnouncementRead($announcement);

        return view('pengumuman.detail', compact(
            'announcement'
        ));
    }
}
