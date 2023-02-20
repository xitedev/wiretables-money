<?php

namespace Xite\WiretablesMoney;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Xite\WiretablesMoney\Components\Fields\Money;

class WiretablesMoneyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('wiretables-money')
            ->hasViews();
    }

    public function packageBooted(): void
    {
        $this->loadViewComponentsAs('wiretables-money', [
            Money::class
        ]);
    }
}
