<nav style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 2rem; background-color: #f8f9fa; border-bottom: 1px solid #e9ecef;">
    
    <div class="navbar-logo">
        <a href="{{ url('/') }}" style="font-weight: bold; font-size: 1.25rem; text-decoration: none; color: #333;">
            ProductOS
        </a>
    </div>

    <div class="navbar-search" style="flex-grow: 0.5; margin: 0 2rem;">
        <form action="/" method="GET" style="display: flex; width: 100%;">
            <input 
                type="text" 
                name="search" 
                placeholder="Search products..." 
                value="{{ request('search') }}"
                style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;"
            >
            <button type="submit" style="padding: 0.5rem 1rem; margin-left: 0.5rem; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Search
            </button>
        </form>
    </div>

    <div class="navbar-auth" style="display: flex; align-items: center; gap: 1rem;">
        @auth
            <a href="/" style="text-decoration: none; color: #333; font-weight: 500;">
                Profile ({{ auth()->user()->name }})
            </a>
            
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: 500;">
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" style="text-decoration: none; color: #007bff; font-weight: 500;">
                Login
            </a>
            <a href="{{ route('register') }}" style="text-decoration: none; background-color: #007bff; color: white; padding: 0.5rem 1rem; border-radius: 4px;">
                Register
            </a>
        @endauth
    </div>

</nav>