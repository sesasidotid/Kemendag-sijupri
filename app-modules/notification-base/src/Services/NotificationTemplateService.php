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

        if ($childList && count($childList) > 0) {
            foreach ($childList as $key => $child) {
                $childTemplate = $this->convertTemplate($child->code, $objectMap);
                $childTemplate[$child->code] = $childTemplate;
            }
        }

        if (!is_array($objectMap) && !is_object($objectMap)) {
            Log::warning('convertTemplate received null or invalid objectMap', [
                'code' => $code,
                'objectMap' => $objectMap
            ]);
            $objectMap = [];
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
}
