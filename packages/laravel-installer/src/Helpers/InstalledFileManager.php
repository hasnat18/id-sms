<?php

namespace RachidLaasri\LaravelInstaller\Helpers;

class InstalledFileManager
{
    /**
     * Create installed file.
     *
     * @return int
     */
    public function create()
    {
        $installedLogFile = storage_path('installed');

        $dateStamp = date('Y/m/d h:i:sa');

        if (! file_exists($installedLogFile)) {
            $message = "The System successfully INSTALLED on " .$dateStamp."\n";

            file_put_contents($installedLogFile, $message);
        } else {
            $message = trans('installer_messages.updater.log.success_message').$dateStamp;

            file_put_contents($installedLogFile, $message.PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        return $message;
    }

    /**
     * Update installed file.
     *
     * @return int
     */
    public function update()
    {
        return $this->create();
    }
}
