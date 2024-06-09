<?php

namespace App\Http\Controllers\Report\Service;

use App\Http\Controllers\SearchService;
use App\Models\Report\Report;
use Illuminate\Support\Facades\DB;
use PHPJasper\PHPJasper;

class ReportService extends Report
{
    use SearchService;
    private $options;

    public function __construct()
    {
        $this->options = [
            'locale' => 'en',
            'db_connection' => config('report.connection')
        ];
    }

    public function generate($request)
    {
        $fileName = $this->generateFileName(['report', $request['report_id'], now()]);

        $input = config('report.input.' . $request['report_id']);
        $output = config('report.output.' . $request['report_id']) . $fileName;
        $this->options['params'] = $request['params'];
        $this->options['format'] = [$request['file_type']];

        $jasper = new JasperInpl();
        $jasper->process($input, $output, $this->options)->customExecute();

        $this->filename = $fileName . '.' . $request['file_type'];
        $this->report_id = $request['report_id'];
        $this->file_type = $request['file_type'];
        $this->type = $request['file_type'];
        $this->status = "SUCCESS";
    }

    public function getFileLocation($id)
    {
        $report = $this->findById($id);
        $output = config('report.output.' . $report->report_id);
        return $output . $report->filename;
    }

    public function findById($id): ?ReportService
    {
        return $this
            ->where('id', $id)
            ->first();
    }

    public function findAll()
    {
        return $this
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip ?? null;
            $this->save();
        });
    }

    private function generateFileName(array $cr)
    {
        $file_name = '';
        foreach ($cr as $key => $value) {
            if ($file_name === '')
                $file_name = $file_name . $value;
            else
                $file_name = $file_name . '_' . $value;
        }

        $file_name = str_replace('-', '', str_replace(':', '', str_replace(' ', '', $file_name)));
        return $file_name;
    }
}

class JasperInpl extends PHPJasper
{
    function customExecute($user = false)
    {
        $this->validateExecute();
        $this->addUserToCommand($user);

        $output = [];
        $returnVar = 0;
        exec($this->command, $output, $returnVar);

        if ($returnVar !== 0) {
            throw new \Exception();
        }

        return $output;
    }
}
