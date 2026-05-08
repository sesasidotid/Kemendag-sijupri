<?php

namespace Database\Seeders;

use Eyegil\WorkflowBase\Commons\Bpmn2;
use Eyegil\WorkflowBase\Models\ProcessInstance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BpmnMigration extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            $bpmn2 = new Bpmn2();

            foreach (config("eyegil.workflow") as $wfName => $value) {
                if ($wfName != 'templates') {
                    ProcessInstance::where("workflow_id", $wfName)
                        ->where("is_completed", false)
                        ->update([
                            "workflow_data" => $bpmn2->parseBpmnXml($value)
                        ]);
                }
            }
        });
    }
}
