<?php

namespace Eyegil\NotificationBase\Services;

use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\NotificationBase\Models\NotificationTemplate;
use Illuminate\Support\Facades\Log;

class NotificationTemplateService
{

    public function findByCode(string $code)
    {
        return NotificationTemplate::findOrThrowNotFound($code);
    }

    public function convertTemplate(string $code, $objectMap): string
    {
        $notificationTemplate = $this->findByCode($code);
        $childList = $notificationTemplate->notificationTemplateChildList;
        $childTemplate = [];

        if (!is_array($objectMap) && !is_object($objectMap)) {
            Log::warning('convertTemplate received null or invalid objectMap', [
                'code' => $code,
                'objectMap' => $objectMap
            ]);
            $objectMap = [];
        }

        if ($childList && count($childList) > 0) {
            foreach ($childList as $key => $child) {
                if (array_key_exists($child->code, $objectMap)) {
                    $isRecursive = !$this->is_assoc($objectMap[$child->code]);

                    if ($isRecursive) {
                        foreach ($objectMap[$child->code] as $key => $childObjectMap) {
                            $childTemplate = $this->convertTemplate($child->code, $childObjectMap);
                            if (isset($childTemplate[$child->code])) {
                                $childTemplate[$child->code] = $childTemplate;
                            } else {
                                $childTemplate[$child->code] = $childTemplate[$child->code] . $childTemplate;
                            }
                        }
                    } else {
                        $childTemplate = $this->convertTemplate($child->code, $objectMap[$child->code]);
                        $childTemplate[$child->code] = $childTemplate;
                    }
                }
            }
        }

        $template = $notificationTemplate->template;
        foreach ($objectMap as $key => $value) {
            $template = str_replace("$$key", $value, $template);
        }

        foreach ($childTemplate as $key => $value) {
            $template = str_replace("$$key", $value, $template);
        }

        return $template;
    }

    public function is_assoc(array $arr): bool
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
