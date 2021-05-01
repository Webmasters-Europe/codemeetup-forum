@extends('layouts.app')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin-area.dashboard') }}">Admin Area</a></li>
            <li class="breadcrumb-item active" aria-current="page">Settings</li>
        </ol>
    </nav>

    <h1>Settings</h1>

    <form action="{{ route('admin-area.settings.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="border rounded-lg p-3" style="background-color: #f7dcc3;">
        <h5>Forum Name</h5>
        <div class="form-row">
          <div class="col">
            <input type="text" class="form-control" name="forum_name" value="{{ $settings->forum_name }}">
          </div>
          <div class="col">
            <input type="text" class="form-control" value="{{ $settings->forum_name }}" disabled>
          </div>
        </div>

        <h5 class="mt-3">Forum Image</h5>
        <div class="form-row">
          <div class="col">
            <input type="file" name="forum_image">
          </div>
          <div class="col">
            @if ($settings->forum_image)
              <img src="{{ asset('storage/'.$settings->forum_image) }}" height="60px">
            @else
              <img src="{{ asset('icons/codemeetup.png') }}" height="60px" class="bg-secondary">
            @endif
          </div>
        </div>
      </div>

      <div class="border rounded-lg mt-3 p-3" style="background-color: #f7dcc3;">
        <h5 class="mt-3">Primary Color (Header, Footer, Button)<small>(in Hex-Code)</small></h5>
        <div class="form-row">
          <div class="col">
            <input type="text" class="form-control" name="primary_color" value="{{ $settings->primary_color }}">
          </div>
          <div class="col">
            <input type="text" class="form-control" value="{{ $settings->primary_color }}" disabled style="background-color: {{ $settings->primary_color }}">
          </div>
        </div>

        <h5 class="mt-3">Button-Text Color <small>(in Hex-Code)</small></h5>
        <div class="form-row">
          <div class="col">
            <input type="text" class="form-control" name="button_text_color" value="{{ $settings->button_text_color }}">
          </div>
          <div class="col">
            <input type="text" class="form-control" value="{{ $settings->button_text_color }}" disabled style="background-color: {{ $settings->button_text_color }}">
          </div>
        </div>

        <h5 class="mt-3">Category Icons Color <small>(in Hex-Code)</small></h5>
        <div class="form-row">
          <div class="col">
            <input type="text" class="form-control" name="category_icons_color" value="{{ $settings->category_icons_color }}">
          </div>
          <div class="col">
            <input type="text" class="form-control" value="{{ $settings->category_icons_color }}" disabled style="background-color: {{ $settings->category_icons_color }}">
          </div>
        </div>

      </div>
      
      <div class="border rounded-lg mt-3 p-3" style="background-color: #f7dcc3;">
        <h5 class="mt-3">Number of Categories on Startpage</h5>
        <div class="form-row">
          <div class="col">
            <input type="number" class="form-control" name="number_categories_startpage" value="{{ $settings->number_categories_startpage }}">
          </div>
          <div class="col">
            <input type="number" class="form-control" value="{{ $settings->number_categories_startpage }}" disabled>
          </div>
        </div>

        <h5 class="mt-3">Number of last Entries on Startpage</h5>
        <div class="form-row">
          <div class="col">
            <input type="number" class="form-control" name="number_last_entries_startpage" value="{{ $settings->number_last_entries_startpage }}">
          </div>
          <div class="col">
            <input type="number" class="form-control" value="{{ $settings->number_last_entries_startpage }}" disabled>
          </div>
        </div>

        <h5 class="mt-3">Number of Posts</h5>
        <div class="form-row">
          <div class="col">
            <input type="number" class="form-control" name="number_posts" value="{{ $settings->number_posts }}">
          </div>
          <div class="col">
            <input type="number" class="form-control" value="{{ $settings->number_posts }}" disabled>
          </div>
        </div>
      </div>

      <div class="border rounded-lg mt-3 p-3" style="background-color: #f7dcc3;">
        <h5 class="mt-3">Copyright</h5>
        <div class="form-row">
          <div class="col">
            <input type="text" class="form-control" name="copyright" value="{{ $settings->copyright }}">
          </div>
          <div class="col">
            <input type="text" class="form-control" value="{{ $settings->copyright }}" disabled>
          </div>
        </div>
      </div>

      <div class="border rounded-lg mt-3 p-3" style="background-color: #f7dcc3;">
        <h5 class="mt-3">Imprint Page</h5>
        <div class="form-row">
          <div class="col">
            <x-easy-mde name="imprint_page" :options="['hideIcons' => ['image']]">{{ old('imprint_page', $settings->imprint_page) }}</x-easy-mde>
          </div>
        </div>
      </div>

      <div class="border rounded-lg mt-3 p-3" style="background-color: #f7dcc3;">
        <h5 class="mt-3">E-Mail for Contact Page</h5>
        <div class="form-row">
          <div class="col">
            <input type="email" class="form-control" name="email_contact_page" value="{{ $settings->email_contact_page }}">
        </div>
        <div class="col">
          <input type="text" class="form-control" value="{{ $settings->email_contact_page }}" disabled>
        </div>
      </div>
      </div>
        <button type="submit" class="btn btn-lg mb-4 mt-3" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">Save Settings</button>
      </form>

@endsection

