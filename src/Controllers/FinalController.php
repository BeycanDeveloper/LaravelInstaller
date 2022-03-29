<?php

namespace Beycan\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Beycan\LaravelInstaller\Events\LaravelInstallerFinished;
use Beycan\LaravelInstaller\Helpers\EnvironmentManager;
use Beycan\LaravelInstaller\Helpers\FinalInstallManager;
use Beycan\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Beycan\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \Beycan\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \Beycan\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
