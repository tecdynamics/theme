<?php

namespace Tec\Theme\Http\Controllers;

use Tec\Setting\Http\Controllers\SettingController;
use Tec\Theme\Forms\Settings\WebsiteTrackingSettingForm;
use Tec\Theme\Http\Requests\WebsiteTrackingSettingRequest;

class WebsiteTrackingSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('packages/theme::theme.settings.website_tracking.title'));

        return WebsiteTrackingSettingForm::create()->renderForm();
    }

    public function update(WebsiteTrackingSettingRequest $request)
    {
        return $this->performUpdate(
            $request->validated()
        )->withUpdatedSuccessMessage();
    }
}
