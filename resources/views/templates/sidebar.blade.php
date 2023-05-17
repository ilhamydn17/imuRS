<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">IMURS</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">IMURS</a>
    </div>
    <ul class="sidebar-menu">
        {{-- konten menu yang ada di sidebar --}}
        <li class="menu-header">Menu</li>
        <li class="nav-item">
            <a href="{{ route('indikator-mutu.index') }}" class="nav-link"><i
                    class="fas fa-regular fa-note-sticky"></i><span>Input Harian</span></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('indikator-mutu.create') }}" class="nav-link"><i class="fas fa-solid fa-square-plus"></i><span>Tambah Data Indikator</span></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('indikator-mutu.showRekap') }}" class="nav-link"><i class="fas fa-solid fa-layer-group"></i><span>Rekap Data Bulanan</span></a>
        </li>
    </ul>
</aside>
