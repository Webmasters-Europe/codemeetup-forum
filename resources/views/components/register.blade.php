@extends('layouts.app')

@section('content')

<div class="container mx-auto p-8 flex">
    <div class="max-w-md w-full mx-auto">
        <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
            <div class="p-8">
                <form id="reg-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-5">
                        <input id="name" type="text" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none"
                        name="name" placeholder='Name' required autocomplete="name" autofocus>
                    </div>

                    <div class="mb-5">
                        <input id="username" type="text" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none"
                        name="username" placeholder='Username' required autocomplete="username">
                    </div>

                    <div class="mb-5">
                        <input id="email" type="text" class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none"
                        name="email" placeholder='Email' required autocomplete="email">
                    </div>


                    <div class="mb-5">
                        <input id="password-registration" type="password"
                        class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none"
                        minlength="8" name="password" placeholder='Password' required autocomplete="new_password">
                    </div>

                    <div class="mb-5">
                        <input id="password-confirm" type="password" 
                        class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none"
                        minlength="8" placeholder="Confirm your password" name="password_confirmation" required
                        autocomplete="new-password">
                    </div>
                                        
                    <button type="submit" class="w-full p-3 mt-4 bg-indigo-600 text-white rounded shadow">Create New Account</button>

                </form>
            </div>
            
            <div class="flex justify-between p-8 text-sm border-t border-gray-300 bg-gray-100">
                
            </div>
        </div>
    </div>
</div>

@endsection