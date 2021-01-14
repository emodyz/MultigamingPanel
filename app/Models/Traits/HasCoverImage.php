<?php

namespace App\Models\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\Pure;

trait HasCoverImage
{
    protected string $defaultDiskPath = 'default';

    private function getDiskPath(): string
    {
        return $this->coverImageDiskPath ?? $this->defaultDiskPath;
    }

    /**
     * Set the model's cover image at creation.
     *
     * @param UploadedFile $coverImage
     * @return void
     */
    public function setInitialCoverImage(UploadedFile $coverImage)
    {
        $path = $coverImage->storePublicly(
            'cover-images/' . $this->getDiskPath(), ['disk' => $this->coverImageDisk()]
        );

        $this->setAttribute('cover_image_path', $path);
    }

    /**
     * Update the model's cover image.
     *
     * @param UploadedFile $coverImage
     * @return void
     */
    public function updateCoverImage(UploadedFile $coverImage)
    {
        tap($this->cover_image_path, function ($previous) use ($coverImage) {
            $this->forceFill([
                'cover_image_path' => $coverImage->storePublicly(
                    'cover-images/' . $this->getDiskPath(), ['disk' => $this->coverImageDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->coverImageDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the model's cover image.
     *
     * @return void
     */
    public function deleteCoverImage()
    {

        Storage::disk($this->coverImageDisk())->delete($this->cover_image_path);

        $this->forceFill([
            'cover_image_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the model's cover image.
     *
     * @return string
     */
    public function getCoverImageUrlAttribute(): string
    {
        return $this->cover_image_path
            ? Storage::disk($this->coverImageDisk())->url($this->cover_image_path)
            : $this->defaultCoverImageUrl();
    }

    /**
     * Get the default cover image URL if no cover image has been uploaded.
     *
     * @return string
     */
    #[Pure] protected function defaultCoverImageUrl(): string
    {
        return '#';
    }

    /**
     * Get the disk that cover images should be stored on.
     *
     * @return string
     */
    protected function coverImageDisk(): string
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }
}
