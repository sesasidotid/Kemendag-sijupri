<?php

namespace App\Http\Controllers\Report;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Service\ReportService;
use App\Http\Controllers\Siap\Service\UnitKerjaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function downloadReport(Request $request)
    {
        $report = new ReportService();
        $reportLocation = $report->getFileLocation($request->id);

        if (file_exists($reportLocation)) {
            return response()->download($reportLocation);
        } else {
            abort(404);
        }
    }

    public function rekomendasiFormasiView(Request $request)
    {
        $report = new ReportService();
        $unitKerja = new UnitKerjaService();

        $data = $request->all();
        $data['attr']['report_id'] = 'rekomendasi_formasi';
        $reportList = $report->setAttr($data['attr'])
            ->setCond(['report_id' => '='])
            ->setOrdr(['created_at' => 'DESC'])->run($data)->createpaginate();
        $unitKerjaList = $unitKerja->findAll();

        return view('report.rekomendasi_formasi', compact(
            'reportList',
            'unitKerjaList'
        ));
    }

    public function generateRekomendasiFormasi(Request $request)
    {
        $request->validate([
            'params' => 'required',
            'file_type' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $report = new ReportService();
            $data = $request->all();

            $data['report_id'] = 'rekomendasi_formasi';
            $report->generate($data);
            $report->customSave();
        });

        return redirect()->back();
    }

    public function deleteReport(Request $request)
    {
        DB::transaction(function () use ($request) {
            $report = new ReportService();
            $report = $report->findById($request->id);
            $output = config('report.output.' . $report->report_id) . $report->filename;

            $report->delete();
            if (file_exists($output)) {
                unlink($output);
            } else {
                throw new BusinessException([
                    "message" => "Gagal menghapus file: file tidak ditemukan",
                    "error code" => "RPT-00001",
                    "code" => 500
                ], 500);
            }
        });

        return redirect()->back();
    }
}
