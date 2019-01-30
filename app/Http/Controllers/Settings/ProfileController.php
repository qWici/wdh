<?php

namespace App\Http\Controllers\Settings;

use Image;
use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'nickname' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'specialization' => 'string'
        ]);

        return tap($user)->update($request->only('nickname', 'email', 'specialization'));
    }

    public function updatePhoto(Request $request)
    {
        $user = auth()->user();

        if($user->image_src !== null){
            File::delete(public_path('/images/users/' . $user->image_src));
        }

        if($request->hasFile('userPhoto')) {
            $this->validate($request, [
                'userPhoto' => 'image|required|mimes:jpeg,png,jpg,gif'
            ]);

            $file = $request->file('userPhoto');
            $imageName = md5(time()) . ".webp";
            $imagePath = "/images/users/" . $imageName;
            Image::make($file->getFileInfo()->getPathname())
                ->encode('png', 75)
                ->fit(200, 200)
                ->save(public_path($imagePath));

            $user->image_src = $imageName;
            $user->save();

            return response()->json(['image_src' => $imageName]);
        }

        return null;
    }
}
