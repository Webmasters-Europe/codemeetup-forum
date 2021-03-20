<div class="container-fluid m-0 p-0">
    <nav class="navbar navbar-dark bg-dark mx-0 mt-0 mb-2 px-4 py-2">
        <div class="container-fluid d-flex m-0 p-0">
            <a class="navbar-brand mr-auto" href="{{ url('/') }}"><img class=" mr-4 my-2" src="https://picsum.photos/50" alt="logo image">FORUM</a>
            <button id="collapse-search-button" class="btn d-lg-none" type="button" data-toggle="collapse" data-target="#search" aria-expanded="false" aria-controls="search">
                <img src="{{ asset('icons/search.png') }}">
            </button>
            <button id="collapse-sidebar-button" class="btn d-lg-none" type="button" data-toggle="collapse" data-target="#sidebar" aria-expanded="false" aria-controls="sidebar">
                <img src="{{ asset('icons/menu.png') }}">
            </button>
            <div id="search" class="d-lg-block collapse">{{$slot}}</div>
        </div>
    </nav>
</div>
