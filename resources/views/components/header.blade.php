
<nav class="border-b border-gray-800 bg-gray-600 text-white">
  <div class="container mx-auto flex items-center justify-between px-4 py-6">
    <ul class="flex items-center">
      <li>
        <a href="{{ route('home') }}">
          <i class="far fa-comments fa-3x"><span class="ml-4 font-sans uppercase">Forum</span></i>
        </a>
      </li> 
      @can('access admin area')
        <li class="ml-16 text-sm">
            <a href="{{ route('admin-area.dashboard') }}">
              <button class="w-full p-3 mt-4 bg-indigo-100 text-gray-900 hover:text-white hover:bg-gray-400 rounded shadow">
                Admin Area
              </button>
            </a>
        </li>
      @endcan
    </ul>
    <div class="flex items-center">
      <livewire:search-posts/>
      @auth
        <div class="flex justify-between ml-4">
          <a href="#">
            <img src="icons/blank-profile-picture.png" alt="avatar" class="rounded-full w-8 h-8">
          </a>
          <form action="{{ route('logout') }}" method="POST" class="ml-4">
            @csrf
            <button type="submit" class="btn btn-dark btn-lg btn-block focus:outline-none">Logout</button>
          </form>
        </div>
      @endauth
      @guest
      <div class="ml-4">
        <a href="{{ route('register') }}">
          Register
        </a>
        <a href="{{ route('login') }}" class="ml-4">
          Login
        </a>
      </div>
      @endguest
    </div>

  </div>
</nav>