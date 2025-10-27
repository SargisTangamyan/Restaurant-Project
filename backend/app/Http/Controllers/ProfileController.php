<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    private function deleteUserImages(User $user)
    {
        $originalPath = str_replace('thumbnail', 'original', $user->profile_image);
        Storage::disk('public')->delete($user->profile_image);
        Storage::disk('public')->delete($originalPath);
    }

    public function show(Request $request)
    {
        $user = $request->user();

        return $this->responder->send(
            'Your Profile',
            ['user' => new UserResource($user)],
        );
    }

    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();

        $user->update($request->validated());

        return $this->responder->send(
            'Profile updated successfully.',
            ['user' => new UserResource($user)]
        );
    }

    public function uploadImage(Request $request, ImageService $imageService)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = $request->user();

        if ($user->profile_image)
        {
            $this->deleteUserImages($user);
        }

        $paths = $imageService->saveImage(
            $request->file('image'),
            ['thumbnail', 'original'],
            300
        );

        $user->update(['profile_image' => $paths['thumbnail']]);

        return $this->responder->send(
            'Profile image uploaded successfully.',
            ['profile_image' => Storage::url($paths['thumbnail'])]
        );
    }

    public function deleteImage(Request $request, ImageService $imageService)
    {
        $user = $request->user();

        if ($user->profile_image)
        {
            $this->deleteUserImages($user);
            $user->update(['profile_image' => null]);
        }

        return $this->responder->send(
            'Profile image deleted successfully.'
        );
    }
}
