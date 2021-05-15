<div class="container-fluid m-0 p-0">
    <nav id="navbar" class="navbar navbar-dark mx-0 mt-0 mb-2 px-0 py-2" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">
        <div class="container-fluid m-0 p-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-9 px-4 d-flex">
                    <a class="navbar-brand mr-auto" href="{{ url('/') }}" style="color: {{ config('app.settings.button_text_color') }};">
                        @if (config('app.settings.forum_image'))
                            <img src="{{ asset('storage/'.config('app.settings.forum_image')) }}" height="50px">
                        @else
                            <img src="{{ asset('icons/codemeetup.png') }}" height="50px">
                        @endif
                        {{ config('app.settings.forum_name') }}</a>
                        <ul class="nav pt-3">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li class="nav-item">
                                    <a class="p-2 nav-link @if(LaravelLocalization::getCurrentLocaleName() === $properties['name']) active disabled @endif" style="color: {{ config('app.settings.button_text_color') }};" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    <button id="collapse-search-button" class="btn d-lg-none" type="button" data-toggle="collapse" data-target="#searchbar" aria-expanded="false" aria-controls="searchbar">
                        <i class="fas fa-search fa-2x"></i>
                    </button>
                    <button id="collapse-sidebar-button" class="btn d-lg-none pr-0" type="button" data-toggle="collapse" data-target="#sidebar" aria-expanded="false" aria-controls="sidebar">
                        <i class="fas fa-bars fa-2x"></i>
                    </button>
                </div>
                <div class="col-lg-3 px-4 d-flex align-items-center">
                    <div id="searchbar" class="d-lg-block collapse w-100">{{$slot}}</div>
                </div>
            </div>
        </div>
    </nav>
</div>

