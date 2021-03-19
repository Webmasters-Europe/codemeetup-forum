<div class="container-fluid m-0 p-0">
    <nav class="navbar navbar-dark bg-dark m-0 px-0 py-2">
        <div class="container-fluid m-0 p-0">
             <a class="navbar-brand" href="{{ url('/') }}"><img class="mx-4 my-2" src="https://picsum.photos/50" alt="logo image">FORUM</a>
            {{$slot}}
            <button id="collapse-sidebar-button" class="btn btn-dark my-2 p-2 d-lg-none" type="button" data-toggle="collapse" data-target="#sidebar" aria-expanded="true" aria-controls="sidebar">
                <img src="{{ asset('icons/menu.png') }}">
            </button>
        </div>
    </nav>
</div>
