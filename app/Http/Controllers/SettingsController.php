<?php

namespace App\Http\Controllers;

use App\Actions\Emodyz\Settings\EditSettings;
use App\Http\Requests\Settings\EditVoiceSettingsRequest;
use App\Settings\VoiceSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:settings-edit')->only(['edit']);

        $this->middleware('can:settings-edit-voice')->only(['updateVoice']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  VoiceSettings  $voiceSettings
     * @return \Illuminate\Http\Response|Response|ResponseFactory
     */
    public function edit(VoiceSettings $voiceSettings)
    {
        return inertia('Settings/Edit', [
          'voiceSettings' => $voiceSettings->toArray()
        ]);
    }

    /**
     * Update the voice settings
     *
     * @param  EditVoiceSettingsRequest  $request
     * @param  EditSettings  $editor
     * @return RedirectResponse
     */
   public function updateVoice(EditVoiceSettingsRequest $request, EditSettings $editor): RedirectResponse
   {
        $editor->editVoiceSettings($request->all());

        flash('Voice Settings', "Your voice settings has been successfully saved.")->success();

        return redirect()->back();
   }
}