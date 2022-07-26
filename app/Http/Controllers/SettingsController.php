<?php

namespace App\Http\Controllers;

use App\Actions\Emodyz\Settings\EditSettings;
use App\Http\Requests\Settings\EditVoiceSettingsRequest;
use App\Services\Bridge\BridgeClientService;
use App\Settings\VoiceSettings;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:settings-edit')->only(['edit']);

        $this->middleware('can:settings-edit_voice')->only(['updateVoice']);

        $this->middleware('can:settings-cp_update_check')->only(['checkForCpUpdate']);
    }

    /**
     * Display a listing of the resource.
     * @param VoiceSettings $voiceSettings
     * @return Response|ResponseFactory
     */
    public function edit(VoiceSettings $voiceSettings)
    {
        $version = 'unknown';
        try {
            $bridgeClient = new BridgeClientService();

            $version = $bridgeClient->getControlPanelVersion();
        } catch (Exception $e) {
            flash('BRIDGE ERROR', $e->getMessage(), 'error');
        }


        return inertia('Settings/Edit', [
            'currentVersion' => $version,
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

    /**
     * Check for control panel updates
     *
     * @return JsonResponse
     */
    public function checkForCpUpdate(): JsonResponse
    {
        $target = 'none';
        try {
            $bridgeClient = new BridgeClientService();

            $target = $bridgeClient->checkForControlPanelUpdate();
        } catch (Exception $e) {
            flash('BRIDGE ERROR', $e->getMessage(), 'error');
        }

        if ($target !== 'none') {
            flash('A new version of the Control Panel is available.', $target, 'info');
        }

        return response()->json([
            $target
        ]);
    }
}
