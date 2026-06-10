<aside
    class="fixed inset-y-0 left-0 z-50 flex w-16 lg:w-64 flex-col justify-between border-r border-slate-200 bg-white p-3 lg:p-5 transition-all duration-300 ease-in-out">

    <div>
        <div
            class="flex items-center justify-center lg:justify-start gap-3 px-1 lg:px-2 py-3 border-b border-slate-100 mb-6">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#0F172A] text-white font-bold text-xl shadow-sm">
                R
            </div>
            <div class="hidden lg:block whitespace-nowrap overflow-hidden">
                <h1 class="font-bold text-slate-900 text-sm tracking-wide leading-tight">Rektor-Kost</h1>
                <p class="text-[11px] text-slate-400 font-medium">Superadmin Panel</p>
            </div>
        </div>

        <nav class="space-y-1">
            <a href="{{ route('superadmin.dashboard') }}"
                class="flex items-center justify-center lg:justify-start gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors
              {{ request()->routeIs('superadmin.dashboard') ? 'bg-slate-100 text-slate-900 font-bold border-r-4 border-slate-900' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold' }}"
                title="Ikhtisar Ekosistem">
                <i class="fa-solid fa-chart-simple text-base w-5 text-center shrink-0"></i>
                <span class="hidden lg:inline whitespace-nowrap">Ikhtisar Ekosistem</span>
            </a>

            <a href="{{ route('superadmin.user.index') }}"
                class="flex items-center justify-center lg:justify-start gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors
              {{ request()->routeIs('superadmin.user.*') ? 'bg-slate-100 text-slate-900 font-bold border-r-4 border-slate-900' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold' }}"
                title="Manajemen User">
                <i class="fa-solid fa-users text-base w-5 text-center shrink-0"></i>
                <span class="hidden lg:inline whitespace-nowrap">Manajemen User</span>
            </a>

            <a href="{{ route('superadmin.owner.index') }}"
                class="flex items-center justify-center lg:justify-start gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors
              {{ request()->routeIs('superadmin.owner.*') ? 'bg-slate-100 text-slate-900 font-bold border-r-4 border-slate-900' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold' }}"
                title="Manajemen Pemilik">
                <i class="fa-solid fa-user-tie text-base w-5 text-center shrink-0"></i>
                <span class="hidden lg:inline whitespace-nowrap">Manajemen Pemilik</span>
            </a>

            <a href="{{ route('superadmin.kost.index') }}"
                class="flex items-center justify-center lg:justify-start gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors
              {{ request()->routeIs('superadmin.kost.*') ? 'bg-slate-100 text-slate-900 font-bold border-r-4 border-slate-900' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-semibold' }}"
                title="Properti">
                <i class="fa-solid fa-house-chimney text-base w-5 text-center shrink-0"></i>
                <span class="hidden lg:inline whitespace-nowrap">Properti</span>
            </a>
        </nav>
    </div>

    <div class="space-y-1 border-t border-slate-100 pt-4">
        <a href="#"
            class="flex items-center justify-center lg:justify-start gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors"
            title="Pengaturan">
            <i class="fa-solid fa-gear text-base w-5 text-center shrink-0"></i>
            <span class="hidden lg:inline whitespace-nowrap">Pengaturan</span>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center lg:justify-start gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold text-red-600 cursor-pointer hover:bg-red-50 transition-colors text-left"
                title="Keluar">
                <i class="fa-solid fa-arrow-right-from-bracket text-base w-5 text-center shrink-0"></i>
                <span class="hidden lg:inline whitespace-nowrap">Keluar</span>
            </button>
        </form>
    </div>
</aside>
