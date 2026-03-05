<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div>
            {{--  Logo --}}
            <a href="/">
                <img class="" src="{{ asset('images/logo.svg') }}" alt="Idea logo" width="100">
            </a>
        </div>

        <div class="flex gap-x-5 items-center">
            {{-- Right side --}}
            @auth
                <a href="{{ route('profile.edit') }}" class="btn-outlined">Edit Profile</a>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="btn-outlined" data-test="logout-button">Logout</button>
                </form>

            @endauth

            @guest
                <a href="/login">Sign In</a>
                <a href="/register" class="btn">Register</a>
            @endguest

        </div>
    </div>
</nav>
