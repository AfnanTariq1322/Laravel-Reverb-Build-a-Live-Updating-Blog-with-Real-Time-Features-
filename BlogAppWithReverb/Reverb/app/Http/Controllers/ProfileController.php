<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Blog;
use App\Events\BlogCreatedEvent;
use App\Events\BlogDeleted;
use App\Events\BlogUpdatedEvent;

class ProfileController extends Controller
{
    public function updateblog(Request $request,$id)
    {
        $request->validate([
            'title'=>'required|string',
            'content'=>'required|string'
        ]);
        $blog = Blog::where('id',$id)->where('user_id',Auth::id())->first();

        $blog->update([
            'title'=> $request->title,
            'content'=> $request->content,
        ]);
       
        event(new BlogUpdatedEvent($blog));
        return redirect()->back()->with('success',"Blog Updated Successfully");
    
    }
    public function delete($id)
    {
        $blog = Blog::where('id',$id)->where('user_id',Auth::id())->first();
        $blog->delete();
        event(new BlogDeleted($id));

        return redirect()->back()->with('success',"Blog Deleted Successfully");
    
    }
    public function Store(Request $request)
    {
        $request->validate([
            'title'=>'required|string',
            'content'=>'required|string'
        ]);

        $blog = Blog::create([
            'user_id'=> auth()->id(),
            'title'=> $request->title,
            'content'=> $request->content,
        ]);
        event(new BlogCreatedEvent($blog));

        return redirect()->back()->with('success',"Blog Created Successfully");
    
    }

     public function blog(Request $request): View
     {
        return view('blog', [
            'user' => $request->user(),
            'blogs'=> Blog::latest()->get(),
        ]);
     }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
