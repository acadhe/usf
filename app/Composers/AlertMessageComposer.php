<?php
namespace App\Composers;
use App\Contracts\Services\AlertMessageService;
use Illuminate\View\View;

class AlertMessageComposer
{
    private $service;

    public function __construct(AlertMessageService $service)
    {
        $this->service = $service;
    }

    public function compose(View $view)
    {
        $view->with('alert_message_success',$this->service->getSuccess());
        $view->with('alert_message_error',$this->service->getError());
        $view->with('alert_message_alert',$this->service->getAlert());
    }

}