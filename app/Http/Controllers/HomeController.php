<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Notifications\SendContactForm as NotificationsSendContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke()
    {
        $numberCategories = config('app.settings.number_categories_startpage');
        $category = Category::first();

        $categories = Category::orderBy('name')->paginate($numberCategories);

        foreach ($categories as $category) {
            $category->latestPost = $category->latestPost();
        }

        return view('welcome', compact('categories'));
    }

    public function imprint()
    {
        return view('imprint');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendmail(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|max:2000',
        ]);

        $receiver = config('app.settings.email_contact_page');

        // Notifications
        Notification::route('mail', $receiver)->notify(new NotificationsSendContactForm($validated));

        return redirect()->route('home')->withStatus(__('Contact-Form successfully sended.'));
    }
}
