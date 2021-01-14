<?php

namespace App\Models\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\Pure;

trait HasLogo
{
    protected string $defaultDiskPath = 'default';

    private function getDiskPath(): string
    {
        return $this->logoDiskPath ?? $this->defaultDiskPath;
    }

    /**
     * Set the model's logo at creation.
     *
     * @param UploadedFile $logo
     * @return void
     */
    public function setInitialCoverImage(UploadedFile $logo)
    {
        $path = $logo->storePublicly(
            'logos/' . $this->getDiskPath(), ['disk' => $this->logoDisk()]
        );

        $this->setAttribute('logo_path', $path);
    }

    /**
     * Update the model's logo.
     *
     * @param UploadedFile $logo
     * @return void
     */
    public function updateLogo(UploadedFile $logo)
    {
        tap($this->logo_path, function ($previous) use ($logo) {
            $this->forceFill([
                'logo_path' => $logo->storePublicly(
                    'logos/'. $this->getDiskPath(), ['disk' => $this->logoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->logoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the model's logo.
     *
     * @return void
     */
    public function deleteLogo()
    {

        Storage::disk($this->logoDisk())->delete($this->logo_path);

        $this->forceFill([
            'logo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the model's logo.
     *
     * @return string
     */
    public function getLogoUrlAttribute(): string
    {
        return $this->logo_path
            ? Storage::disk($this->logoDisk())->url($this->logo_path)
            : $this->defaultLogoUrl();
    }

    /**
     * Get the default logo URL if no logo has been uploaded.
     *
     * @return string
     */
    #[Pure] protected function defaultLogoUrl(): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that logos should be stored on.
     *
     * @return string
     */
    protected function logoDisk(): string
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }
}
