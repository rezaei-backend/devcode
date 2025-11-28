<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Str;

trait LogsActivity
{
    protected function logActivity(string $action, $model, string $customMessage = null)
    {
        $modelNameFa = $this->getPersianModelName($model);
        $title       = $this->getTitle($model);
        $actionText  = $this->getPersianAction($action);

        $message = $customMessage
            ?? "رکوردی از مدل {$modelNameFa} {$actionText} شد." . ($title ? " {$title}" : '');

        ActivityLog::record(
            $action,
            get_class($model),
            $model->id ?? null,
            $message
        );
    }

    private function getPersianModelName($model): string
    {
        return match (class_basename($model)) {
            'Doc'       => 'مستند',
            'Subject'   => 'موضوع',
            'Language'  => 'زبان',
            'Quiz'      => 'آزمون',
            'Question'  => 'سوال',
            'Setting'   => 'تنظیمات سایت',
            default     => class_basename($model)
        };
    }

    private function getTitle($model): string
    {
        return match (true) {
            isset($model->title)        => "عنوان: {$model->title}",
            isset($model->name)         => "نام: {$model->name}",
            isset($model->question_text)=> "متن سوال: " . Str::limit($model->question_text, 60),
            isset($model->site_name)    => "نام سایت: {$model->site_name}",
            default                     => ''
        };
    }

    private function getPersianAction(string $action): string
    {
        return match ($action) {
            'created' => 'ایجاد',
            'updated' => 'ویرایش',
            'deleted' => 'حذف',
            default   => 'عملیات ناشناخته',
        };
    }
}
