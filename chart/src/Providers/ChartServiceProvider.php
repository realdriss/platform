<?php

namespace RealDriss\Chart\Providers;

use RealDriss\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Support\ServiceProvider;

class ChartServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot()
    {
        $this->setNamespace('core/chart')
            ->loadAndPublishViews();
    }
}
