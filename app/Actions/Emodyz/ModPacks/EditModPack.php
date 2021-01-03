<?php


namespace App\Actions\Emodyz\ModPacks;

use App\Exceptions\ModPackException;
use App\Models\Modpack;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EditModPack
{

  public function editModPack(Modpack $modPack, array $input)
  {
    $name = Arr::get($input, 'name');
    $servers = Arr::get($input, 'servers', []);
    $path = Arr::get($input, 'path', Str::ascii($name));
    $disk = Arr::get($input, 'disk', 'modpacks');

    if (!Arr::exists(config('filesystems.disks'), $disk)) {
      throw ModPackException::invalidDisk($disk);
    }

    $modPack->setAttribute('name', $name);
    $modPack->setAttribute('disk', $disk);

    if ($path !== $modPack->path) {
      Storage::disk($disk)->move($modPack->path, $path);
      $modPack->setAttribute('path', $path);
    }

    $modPack->save();

    $modPack->servers()->sync($servers);
  }

}
