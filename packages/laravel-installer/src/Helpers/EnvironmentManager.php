<?php

namespace RachidLaasri\LaravelInstaller\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (! file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Get the the .env file path.
     *
     * @return string
     */
    public function getEnvPath()
    {
        return $this->envPath;
    }

    /**
     * Get the the .env.example file path.
     *
     * @return string
     */
    public function getEnvExamplePath()
    {
        return $this->envExamplePath;
    }

    /**
     * Save the edited content to the .env file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFileClassic(Request $input)
    {
        $message = trans('installer_messages.environment.success');

        try {
            file_put_contents($this->envPath, $input->get('envConfig'));
        } catch (Exception $e) {
            $message = trans('installer_messages.environment.errors');
        }

        return $message;
    }

    /**
     * Save the form content to the .env file.
     *
     * @param Request $request
     * @return string
     */
    public function saveFileWizard(Request $request)
    {
        $results = trans('installer_messages.environment.success');

        $envFileData =
            'APP_NAME=\''.$request->app_name."'\n".
            'APP_TAGLINE=\''.$request->app_tagline."'\n".
            'APP_KEY='.'base64:'.base64_encode(Str::random(32))."\n".
            'APP_URL='.$request->app_url."\n".
            'DB_CONNECTION='.$request->database_connection."\n".
            'DB_HOST='.$request->database_hostname."\n".
            'DB_PORT='.$request->database_port."\n".
            'DB_DATABASE='.$request->database_name."\n".
            'DB_USERNAME='.$request->database_username."\n".
            'DB_PASSWORD='.$request->database_password."\n";

        // Read the existing contents of the .env file
        $existingEnvData = file_get_contents($this->envPath);

        // Split the data into an array of lines
        $existingEnvLines = explode("\n", $existingEnvData);

        // Loop through the new data lines and check if the key already exists
        $newEnvLines = explode("\n", $envFileData);
        foreach ($newEnvLines as $newLine) {
            // Extract the key from the new line
            $newKey = substr($newLine, 0, strpos($newLine, '='));

            // Check if the key already exists in the existing lines
            $keyExists = false;
            foreach ($existingEnvLines as $existingLine) {
                // Extract the key from the existing line
                $existingKey = substr($existingLine, 0, strpos($existingLine, '='));

                // If the keys match, mark the key as existing
                if ($newKey == $existingKey) {
                    $keyExists = true;
                    break;
                }
            }

            // If the key doesn't exist, add the new line to the existing data
            if (!$keyExists) {
                $existingEnvData .= $newLine . "\n";
            }
        }

        try {
            file_put_contents($this->envPath, $existingEnvData);
        } catch (Exception $e) {
            $results = trans('installer_messages.environment.errors');
        }

        return $results;
    }

    // public function saveFileWizard(Request $request)
    // {
    //     $results = trans('installer_messages.environment.success');

    //     $envFileData =
    //     'APP_NAME=\''.$request->app_name."'\n".
    //     'APP_TAGLINE=\''.$request->app_tagline."'\n".
    //     'APP_KEY='.'base64:'.base64_encode(Str::random(32))."\n".
    //     'APP_URL='.$request->app_url."\n\n".
    //     'DB_CONNECTION='.$request->database_connection."\n".
    //     'DB_HOST='.$request->database_hostname."\n".
    //     'DB_PORT='.$request->database_port."\n".
    //     'DB_DATABASE='.$request->database_name."\n".
    //     'DB_USERNAME='.$request->database_username."\n".
    //     'DB_PASSWORD='.$request->database_password."\n\n";

    //     try {
    //         file_put_contents($this->envPath, $envFileData);
    //     } catch (Exception $e) {
    //         $results = trans('installer_messages.environment.errors');
    //     }

    //     return $results;
    // }
}
