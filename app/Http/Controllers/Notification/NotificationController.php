<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Notification\Service\NotificationSMTPService;
use App\Http\Controllers\Ukom\Service\UkomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{

    public function sendUkomInternalEmail(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'jenis_ukom' => 'required',
            'type' => 'required',
        ]);
        $ukom = new UkomService();
        $ukom = $ukom->findLatestByEmailAndJenisUkom($request->email, $request->jenis_ukom);

        Mail::to($request->email)->send(new NotificationSMTPService("ukom_mengulang", [
            "subject" => "Pendaftaran Ukom (Mengulang)",
            "params" => [
                "url" => url('/page/ukom/internal?type=' . $request->type . '&jenis_ukom=' . $request->jenis_ukom . '&email=' . $request->email . '&pendaftaran_code=' . $ukom->pendaftaran_code),
            ],
        ]));

        return view('info.email');
    }

    public function sendUkomExternalEmail(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'jenis_ukom' => 'required',
            'type' => 'required',
        ]);
        $ukom = new UkomService();
        $ukom = $ukom->findLatestByEmailAndJenisUkom($request->email, $request->jenis_ukom);

        Mail::to($request->email)->send(new NotificationSMTPService("ukom_mengulang", [
            "subject" => "Pendaftaran Ukom (Mengulang)",
            "url" => '/page/ukom/external?type=' . $request->type . '&jenis_ukom=' . $request->jenis_ukom . '&email=' . $request->email . '&pendaftaran_code=' . $ukom->pendaftaran_code
        ]));

        return view('message.email');
    }
}
