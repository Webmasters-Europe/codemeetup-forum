<div class="container-fluid m-0 p-0">
    <nav class="navbar navbar-dark bg-dark mx-0 mt-0 mb-2 px-0 py-2">
        <div class="container-fluid m-0 p-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-9 px-4 d-flex">
                    <a class="navbar-brand mr-auto" href="{{ url('/') }}"><img class=" mr-4 my-2" src="https://picsum.photos/50" alt="logo image">{{ config('app.settings.forum_name') }}</a>
                    <button id="collapse-search-button" class="btn d-lg-none" type="button" data-toggle="collapse" data-target="#searchbar" aria-expanded="false" aria-controls="searchbar">
                        <img src="{{ asset('icons/search.png') }}">
                    </button>
                    <button id="collapse-sidebar-button" class="btn d-lg-none pr-0" type="button" data-toggle="collapse" data-target="#sidebar" aria-expanded="false" aria-controls="sidebar">
                        <img src="{{ asset('icons/menu.png') }}">
                    </button>
                </div>
                <div class="col-lg-3 px-4 d-flex align-items-center">
                    <div id="searchbar" class="d-lg-block collapse w-100">{{$slot}}</div>
                </div>  
            </div> 
        </div>
    </nav>
</div>

