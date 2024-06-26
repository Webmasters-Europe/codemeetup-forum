<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except('show');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(User $user)
    {
        $this->authorize('view', User::class);

        if (auth()->check() && auth()->user()->is($user)) {
            if ($user->has('unreadNotifications')) {
                $user->unreadNotifications->markAsRead();
            }
            $notifications = $user->notifications()->paginate(5, ['*'], 'notifications');
        } else {
            $notifications = collect();
        }

        $posts = $user->posts()->orderBy('created_at', 'desc')->with('uploads')->paginate(5, ['*'], 'posts');
        $replies = $user->postReplies()->orderBy('created_at', 'desc')->paginate(5, ['*'], 'replies');

        return view('profiles.show', compact('user', 'posts', 'replies', 'notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(User $user)
    {
        $this->authorize('update', [User::class, $user]);

        return view('profiles.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    // public function update(UserRequest $request, User $user): \Illuminate\Http\Response
    public function update(UserRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', [User::class, $user]);

        if ($request->password != null) {
            $password = bcrypt($request->password);
        } else {
            $password = $user->password;
        }

        $request['reply_email_notification'] = (int) $request->has('reply_email_notification');

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'reply_email_notification' => $request->reply_email_notification,
            'password' => $password,
        ]);

        if ($request->avatar) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
            $user->save();
        }

        return redirect()->route('home')->withStatus(__('Profile successfully updated.'));
    }

    public function reset_avatar()
    {
        $user = auth()->user();

        $this->authorize('update', [User::class, $user]);

        $user->update([
            'avatar' => null,
        ]);

        return redirect()->route('home')->withStatus(__('Avatar successfully set to default picture.'));
    }
}
