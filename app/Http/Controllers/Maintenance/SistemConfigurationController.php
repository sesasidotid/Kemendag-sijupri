<?php

namespace App\Http\Controllers\Maintenance;

use App\Exceptions\BusinessException;
use App\Http\Controllers\Controller;
use App\Models\Maintenance\SystemConfiguration;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SistemConfigurationController extends Controller
{

    public function index()
    {
        $systemConfigurationList = SystemConfiguration::all();
        return view('maintenance.system_configuration.index', compact(
            'systemConfigurationList'
        ));
    }

    public function detail(Request $request)
    {
        $systemConfiguration = SystemConfiguration::where('code', $request->code)->first();
        return view('maintenance.system_configuration.detail', compact(
            'systemConfiguration'
        ));
    }

    public function edit(KonfigurasiRequest $request)
    {
        DB::transaction(function () use ($request) {
            $systemConfiguration = SystemConfiguration::where('code', $request->code)->first();
            $newProperty = $request->input('property');
            // $request->validate($this->validateConfiguration($systemConfiguration, $newProperty));

            if ($systemConfiguration->type === "static")
                $systemConfiguration->property = $this->safeUpdateStaticType($systemConfiguration, $systemConfiguration->property, $newProperty);
            else if ($systemConfiguration->type === "dynamic")
                $systemConfiguration->property = $this->safeUpdateDynamicType($systemConfiguration, $systemConfiguration->property, $newProperty);
            $systemConfiguration->save();
        });

        return redirect()->back();
    }

    private function safeUpdateStaticType($systemConfiguration, $property, $newProperty)
    {
        if (isset($property['input_type'])) {
            $property['value'] = $newProperty['value'] ?? '';
        } else if (is_array($property)) {
            foreach ($property as $index => $old) {
                $property[$index] = $this->safeUpdateStaticType($systemConfiguration, $old, $newProperty[$index]);
            }
        }

        return $property;
    }

    private function safeUpdateDynamicType($systemConfiguration, $property, $newProperty)
    {
        if (isset($property['input_type'])) {
            if (isset($newProperty['values']) && is_array($newProperty['values'])) {
                $property['values'] = [];
                foreach ($newProperty['values'] as $key => $value) {
                    if ($value && $value !== '') {
                        $property['values'][] = $value;
                    }
                }
            }
        } else if (is_array($property)) {
            foreach ($property as $index => $old) {
                $property[$index] = $this->safeUpdateDynamicType($systemConfiguration, $old, ($newProperty[$index] ?? null));
            }
        }

        return $property;
    }

    function validateConfiguration($systemConfiguration, $array, $parentKey = null)
    {
        $result = [];

        foreach ($array as $key => $value) {
            $currentKey = $parentKey ? $parentKey  . '[' . $key . ']' : '[' . $key . ']';

            if (is_array($value)) {
                $result = array_merge($result, $this->validateConfiguration($systemConfiguration, $value, $currentKey));
            } else {
                $result['property' . $currentKey] = 'required|' . $systemConfiguration->validation;
            }
        }

        return $result;
    }
}


class KonfigurasiRequest extends FormRequest
{
    public function rules()
    {
        $systemConfiguration = SystemConfiguration::where('code', $this->query('code'))->first();
        return $this->validateConfiguration($systemConfiguration, $this->request->all()['property']);
    }

    private function validateConfiguration($systemConfiguration, $array, $parentKey = null)
    {
        $result = [];

        foreach ($array as $key => $value) {
            $currentKey = $parentKey ? $parentKey  . '.' . $key  : $key;

            if (is_array($value)) {
                $result = array_merge($result, $this->validateConfiguration($systemConfiguration, $value, $currentKey));
            } else {
                if ($systemConfiguration->validation && $value && $value != '') {
                    $this->validationValue($systemConfiguration, $value);
                    $result['property.' . $currentKey] = ['regex:' . $systemConfiguration->validation];
                }
            }
        }

        return $result;
    }

    private function validationValue($systemConfiguration, $value)
    {
        if ($systemConfiguration->validation_type == "math")
            try {
                eval('$mathTest = 1 ' . $value . ';');
            } catch (\Throwable $th) {
                throw new BusinessException([
                    "message" => "Rumus Tidak dapat dihitung",
                    "error code" => "SCO-00001",
                    "code" => 500
                ], 500);
            }
    }
}
