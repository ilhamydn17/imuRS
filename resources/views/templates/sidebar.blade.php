<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="#">IMURS</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <img src="{{ asset('../custom-image/logo-rs.png') }}" alt="logo" width="40" class="shadow-light rounded-circle">
    </div>
    <ul class="sidebar-menu">
        {{-- konten menu yang ada di sidebar --}}
        <li class="menu-header">Menu</li>
        <li class="nav-item">
            <a href="{{ route('indikator-mutu.index') }}" class="nav-link"><i
                    class="fas fa-regular fa-note-sticky"></i><span>Input Harian</span></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('indikator-mutu.showRekap') }}" class="nav-link"><i class="fas fa-solid fa-layer-group"></i><span>Rekap Data Bulanan</span></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('indikator-mutu.create') }}" class="nav-link"><i class="fas fa-solid fa-square-plus"></i><span>Tambah Kategori</span></a>
        </li>
    </ul>
</aside>
