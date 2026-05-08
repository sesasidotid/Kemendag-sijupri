<?php

namespace Eyegil\SijupriMaintenance\Services;

use Carbon\Carbon;
use Eyegil\SijupriMaintenance\Models\Counter;
use Illuminate\Support\Facades\DB;

class CounterService
{
    public function counter($code, $reset_condition = null)
    {
        return DB::transaction(function () use ($code, $reset_condition) {
            $counter = Counter::find($code);

            if ($counter) {
                if ($reset_condition && $reset_condition($counter)) {
                    $counter->num = 1;
                } else {
                    $counter->num = $counter->num + 1;
                }
                $counter->last_updated = Carbon::now();
                $counter->updated_by = "system";
                $counter->save();
            } else {
                $counter = new Counter();
                $counter->code = $code;
                $counter->num = 1;
                $counter->last_updated = Carbon::now();
                $counter->date_created = Carbon::now();
                $counter->created_by = "system";
                $counter->save();
            }

            return $counter->num;
        });
    }

    public function findByCode($code)
    {
        return Counter::findOrThrowNotFound($code);
    }

    public function update($code, $value)
    {
        return DB::transaction(function () use ($code, $value) {
            $counter = Counter::find($code);

            if ($counter) {
                $counter->num = (int) $value;
                $counter->last_updated = Carbon::now();
                $counter->updated_by = "system";
                $counter->save();
            } else {
                $counter = new Counter();
                $counter->code = $code;
                $counter->num = (int) $value;
                $counter->last_updated = Carbon::now();
                $counter->date_created = Carbon::now();
                $counter->created_by = "system";
                $counter->save();
            }

            return $counter->num;
        });
    }
}
