<nav x-data="{ open: false }" class="w-full bg-accent shadow rounded-xl mt-5 px-2 mb-5">
    <div class="navbar">
        <div class="navbar-start">
            <a class="btn btn-ghost text-xl" href="/"> <img src="{{asset("img/logo.png")}}" class="h-12">Pondok Indah Golf</a>
        </div>

        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1 text-xl">
                <li><a href="listkaryawan">List Karyawan</a></li>
                <li><a href="nilaikaryawan">Nilai Karyawan</a></li>
                <li><a href="profile">Profil</a></li>
            </ul>
        </div>

        <div class="navbar-end">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-outline rounded-btn">{{ Auth::user()->name }}</div>
                <ul tabindex="0" class="menu dropdown-content bg-base-100 rounded-box z-[1] mt-4 w-52 p-2 shadow">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <li>
                            <button type="submit" class="w-full text-left">Logout</button>
                        </li>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</nav>