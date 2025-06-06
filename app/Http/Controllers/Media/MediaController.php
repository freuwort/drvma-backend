<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\CopyMediaRequest;
use App\Http\Requests\Media\DestroyMediaRequest;
use App\Http\Requests\Media\MoveMediaRequest;
use App\Http\Requests\Media\RenameMediaRequest;
use App\Http\Requests\Media\ShareMediaRequest;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function repair(Request $request) {
        $this->authorize('adminAction', [Media::class]);

        $request->validate([
            'action' => ['required', 'in:discover'],
            'path' => ['required', 'string'],
        ]);

        switch ($request->action) {
            case 'discover': Media::discover($request->path); break;
        }
    }



    public function rename(RenameMediaRequest $request)
    {
        $this->authorize('rename', [Media::class, $request->validated('path')]);
        Media::findPathOrFail($request->validated('path'))->rename($request->validated('name'));
    }



    public function share(ShareMediaRequest $request)
    {
        $this->authorize('share', [Media::class, $request->validated('path')]);

        $media = Media::findPathOrFail($request->validated('path'));
        
        $media->removeAllAccess();
        $media->addAccess(null, ['permission' => $request->validated('public_access')]);
        $media->update(['inherit_access' => $request->validated('inherit_access')]);

        foreach ($request->access as $access) {
            $media->addAccess([
                'id' => $access['permissible_id'],
                'type' => $access['permissible_type'],
            ], ['permission' => $access['permission']]);
        }
    }



    public function move(MoveMediaRequest $request)
    {
        $this->authorize('moveMany', [Media::class, $request->validated('paths'), $request->validated('destination')]);
        Media::moveMany($request->validated('paths'), $request->validated('destination'));
    }



    public function copy(CopyMediaRequest $request)
    {
        $this->authorize('copyMany', [Media::class, $request->validated('paths'), $request->validated('destination')]);
        Media::copyMany($request->validated('paths'), $request->validated('destination'));
    }



    public function destroy(DestroyMediaRequest $request)
    {
        $this->authorize('deleteMany', [Media::class, $request->validated('paths')]);
        Media::deleteMany($request->validated('paths'));
    }
}
