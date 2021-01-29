<?php


namespace App\Actions\Emodyz\ModPacks;


use App\Exceptions\ModPackException;
use App\Models\Modpack;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CreateModPack
{
    /**
     * @param array $input
     * @return Modpack
     * @throws ModPackException
     */
  public function storeNewModPack(array $input): Modpack
  {
    $modPack = new Modpack;

    $name = Arr::get($input, 'name');
    $gameId = Arr::get($input, 'game');
    $servers = Arr::get($input, 'servers', []);
    $path = Arr::get($input, 'path', Str::ascii($name));
    $disk = Arr::get($input, 'disk', 'modpacks');

    if (!Arr::exists(config('filesystems.disks'), $disk)) {
      throw ModPackException::invalidDisk($disk);
    }

    $modPack->setAttribute('name', $name);
    $modPack->setAttribute('game_id', $gameId);
    $modPack->setAttribute('path', $path);
    $modPack->setAttribute('disk', $disk);

    $modPack->save();

    $modPack->servers()->sync($servers);

    return $modPack;
  }
}
