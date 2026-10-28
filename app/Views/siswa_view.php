<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa XI RPL</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Smooth transition for sidebar & main content area */
        #sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #mainContent {
            transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Desktop Sidebar behavior (>= 1024px) */
        @media (min-width: 1024px) {
            #sidebar {
                width: 60px;
            }

            #sidebar .sidebar-label {
                opacity: 0;
                max-width: 0;
                white-space: nowrap;
                overflow: hidden;
                pointer-events: none;
                transition: opacity 0.2s ease, max-width 0.3s ease;
            }

            #sidebar:hover,
            #sidebar.is-pinned {
                width: 300px;
            }

            #sidebar:hover .sidebar-label,
            #sidebar.is-pinned .sidebar-label {
                opacity: 1;
                max-width: 220px;
                pointer-events: auto;
            }

            #mainContent.sidebar-pinned {
                padding-left: 300px;
            }
        }

        /* Mobile Sidebar behavior (< 1024px) */
        @media (max-width: 1023px) {
            #sidebar {
                width: 300px;
            }

            #sidebar .sidebar-label {
                opacity: 1;
                max-width: 220px;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-blue-500 selection:text-white">

    <!-- Mobile Overlay Backdrop -->
    <div id="mobileBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-30 hidden transition-opacity duration-300" onclick="toggleMobileSidebar()"></div>

    <!-- Collapsible Sidebar -->
    <aside id="sidebar" class="fixed top-0 bottom-0 left-0 z-40 bg-slate-900 text-slate-100 flex flex-col justify-between -translate-x-full lg:translate-x-0 shadow-2xl border-r border-slate-800">
        <div>
            <!-- Sidebar Header / Brand Logo -->
            <div class="h-16 flex items-center px-3.5 border-b border-slate-800/80 overflow-hidden shrink-0">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white shrink-0 shadow-md shadow-blue-500/20">
                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                </div>
                <div class="sidebar-label ml-3 flex flex-col justify-center">
                    <span class="font-bold text-white text-sm tracking-tight leading-none">XI RPL</span>
                    <span class="text-[11px] text-slate-400 leading-tight mt-1">Siswa Management</span>
                </div>
                <!-- Close Button on Mobile Drawer -->
                <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden ml-auto p-1.5 text-slate-400 hover:text-white rounded-lg focus:outline-none" aria-label="Tutup Menu">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-2.5 space-y-1.5 mt-2">
                <!-- Dashboard (Active) -->
                <a href="<?= base_url(); ?>" class="flex items-center px-2.5 py-2.5 rounded-xl text-white bg-blue-600 font-medium shadow-md shadow-blue-600/20 transition-colors group">
                    <span class="w-7 h-7 flex items-center justify-center shrink-0 text-white text-base">
                        <i class="fa-solid fa-chart-pie"></i>
                    </span>
                    <span class="sidebar-label ml-2 text-sm font-semibold">Dashboard</span>
                </a>

                <!-- Profile -->
                <button type="button" onclick="openModal('modalProfile')" class="w-full flex items-center px-2.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 font-medium transition-colors group text-left">
                    <span class="w-7 h-7 flex items-center justify-center shrink-0 text-slate-400 group-hover:text-blue-400 text-base transition-colors">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <span class="sidebar-label ml-2 text-sm">Profile</span>
                </button>

                <!-- Settings -->
                <button type="button" onclick="openModal('modalSettings')" class="w-full flex items-center px-2.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/80 font-medium transition-colors group text-left">
                    <span class="w-7 h-7 flex items-center justify-center shrink-0 text-slate-400 group-hover:text-amber-400 text-base transition-colors">
                        <i class="fa-solid fa-gear"></i>
                    </span>
                    <span class="sidebar-label ml-2 text-sm">Settings</span>
                </button>
            </nav>
        </div>

        <!-- Sidebar Footer / Logout -->
        <div class="p-2.5 border-t border-slate-800/80">
            <button type="button" onclick="confirmLogout()" class="w-full flex items-center px-2.5 py-2.5 rounded-xl text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 font-medium transition-colors group text-left">
                <span class="w-7 h-7 flex items-center justify-center shrink-0 text-rose-400 group-hover:text-rose-300 text-base transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </span>
                <span class="sidebar-label ml-2 text-sm">Logout</span>
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div id="mainContent" class="min-h-screen flex flex-col transition-all duration-300 lg:pl-[60px]">
        
        <!-- Top Navbar -->
        <header class="sticky top-0 z-20 bg-white/95 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 py-3.5 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <!-- Mobile Menu Hamburger Button -->
                <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Buka Menu Mobile">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>

                <!-- Desktop Sidebar Toggle Button -->
                <button type="button" onclick="toggleDesktopSidebar()" id="desktopToggleBtn" class="hidden lg:flex p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" aria-label="Toggle Sidebar Desktop" title="Toggle Lebar Sidebar">
                    <i class="fa-solid fa-bars-staggered text-lg"></i>
                </button>

                <!-- Page Header Title -->
                <div>
                    <h1 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">Data Siswa XI RPL</h1>
                    <p class="text-xs text-slate-500 hidden sm:block">Aplikasi Manajemen Data Siswa Rekayasa Perangkat Lunak</p>
                </div>
            </div>

            <!-- Right Navbar Utilities -->
            <div class="flex items-center gap-3">
                <span class="hidden md:inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                    Sistem Aktif
                </span>
                <button type="button" onclick="openModal('modalProfile')" class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                        AD
                    </div>
                    <span class="hidden md:block text-xs font-semibold text-slate-700 text-left leading-tight">
                        Admin
                    </span>
                </button>
            </div>
        </header>

        <!-- Main Dashboard Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">
            <!-- Card Container -->
            <section class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-6">
                <!-- Card Header -->
                <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Daftar Siswa Terdaftar</h2>
                        <p class="text-sm text-slate-500 mt-1">Kelola dan pantau seluruh data siswa kelas XI RPL secara terorganisir.</p>
                    </div>
                    <div>
                        <button type="button" onclick="openModal('modalTambah')" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold rounded-xl shadow-sm hover:shadow transition-all focus:outline-none focus:ring-4 focus:ring-blue-100">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>Tambah Data Siswa</span>
                        </button>
                    </div>
                </div>

                <!-- Responsive Table Wrapper -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-900 text-slate-200 text-xs font-semibold uppercase tracking-wider">
                                <th scope="col" class="py-3.5 px-4 text-center w-16">No</th>
                                <th scope="col" class="py-3.5 px-4">NIS</th>
                                <th scope="col" class="py-3.5 px-4">Nama</th>
                                <th scope="col" class="py-3.5 px-4">Kelas</th>
                                <th scope="col" class="py-3.5 px-4 text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <?php if (!empty($siswa)): ?>
                                <?php $no = (($page - 1) * $perPage) + 1; ?>
                                <?php foreach ($siswa as $row): ?>
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="py-3.5 px-4 text-center font-medium text-slate-500"><?= $no++; ?></td>
                                        <td class="py-3.5 px-4 font-mono font-medium text-slate-700"><?= esc($row['nis']); ?></td>
                                        <td class="py-3.5 px-4 font-semibold text-slate-900"><?= esc($row['nama']); ?></td>
                                        <td class="py-3.5 px-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                                <?= esc($row['kelas']); ?>
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <div class="inline-flex items-center gap-2 justify-center">
                                                <button type="button" onclick="openModal('modalEdit<?= $row['id']; ?>')" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white text-xs font-medium rounded-lg shadow-2xs hover:shadow-xs transition focus:outline-none focus:ring-2 focus:ring-amber-300">
                                                    <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                                    <span>Edit</span>
                                                </button>
                                                <a href="<?= base_url('home/hapus/' . $row['id']); ?>" onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-500 hover:bg-rose-600 active:bg-rose-700 text-white text-xs font-medium rounded-lg shadow-2xs hover:shadow-xs transition focus:outline-none focus:ring-2 focus:ring-rose-300">
                                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                    <span>Hapus</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="py-12 px-4 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-xl">
                                                <i class="fa-regular fa-folder-open"></i>
                                            </div>
                                            <p class="font-medium text-slate-600">Belum ada data siswa.</p>
                                            <p class="text-xs text-slate-400">Silakan klik tombol "Tambah Data Siswa" untuk menambahkan data baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <div class="p-4 sm:p-5 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <?php if ($pager->getPreviousPageURI() !== null) : ?>
                            <a href="<?= $pager->getPreviousPageURI() ?>" class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-4 focus:ring-blue-100 rounded-lg text-sm font-medium transition-colors">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                                <span>Previous</span>
                            </a>
                        <?php else : ?>
                            <button class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-slate-200 text-slate-400 bg-slate-50 rounded-lg text-sm font-medium cursor-not-allowed" disabled>
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                                <span>Previous</span>
                            </button>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if ($pager->getNextPageURI() !== null) : ?>
                            <a href="<?= $pager->getNextPageURI() ?>" class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-4 focus:ring-blue-100 rounded-lg text-sm font-medium transition-colors">
                                <span>Next</span>
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </a>
                        <?php else : ?>
                            <button class="inline-flex items-center gap-1.5 px-3.5 py-2 border border-slate-200 text-slate-400 bg-slate-50 rounded-lg text-sm font-medium cursor-not-allowed" disabled>
                                <span>Next</span>
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <?php
    $daftarKelas = [
        'Rekayasa Perangkat Lunak (RPL)' => [
            'Kelas 10 RPL',
            'Kelas 11 RPL',
            'Kelas 12 RPL',
        ],
        'Multimedia (MM)' => [
            'Kelas 10 MM',
            'Kelas 11 MM',
            'Kelas 12 MM',
        ],
        'Broadcasting (BC)' => [
            'Kelas 10 BC',
            'Kelas 11 BC',
            'Kelas 12 BC',
        ],
    ];
    $allKelasOptions = array_merge(...array_values($daftarKelas));
    ?>

    <!-- Edit Student Modals (Generated for each student) -->
    <?php if (!empty($siswa)): ?>
        <?php foreach ($siswa as $row): ?>
            <div id="modalEdit<?= $row['id']; ?>" class="modal-container fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-4 overflow-y-auto" onclick="if(event.target === this) closeModal('modalEdit<?= $row['id']; ?>')">
                <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-100 transform transition-all animate-in fade-in zoom-in-95 duration-200">
                    <!-- Green Modal Header -->
                    <div class="px-6 py-4 bg-emerald-600 text-white flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-user-pen"></i>
                            <h3 class="font-bold text-white text-base">Edit Data Siswa</h3>
                        </div>
                        <button type="button" onclick="closeModal('modalEdit<?= $row['id']; ?>')" class="text-white/80 hover:text-white rounded-lg p-1 focus:outline-none" aria-label="Tutup Modal">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <!-- Edit Form -->
                    <form action="<?= base_url('home/edit/' . $row['id']); ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">NIS</label>
                                <input type="text" name="nis" value="<?= esc($row['nis']); ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition" placeholder="Masukkan NIS" required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                                <input type="text" name="nama" value="<?= esc($row['nama']); ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition" placeholder="Masukkan Nama Lengkap" required>
                            </div>
                            <div>
                                <label for="kelas_edit_<?= $row['id']; ?>" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Kelas / Jurusan</label>
                                <select name="kelas" id="kelas_edit_<?= $row['id']; ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition bg-white" required>
                                    <option value="" disabled <?= empty($row['kelas']) ? 'selected' : ''; ?>>-- Pilih Kelas / Jurusan --</option>
                                    <?php if (!empty($row['kelas']) && !in_array($row['kelas'], $allKelasOptions, true)): ?>
                                        <option value="<?= esc($row['kelas']); ?>" selected><?= esc($row['kelas']); ?> (Tersimpan Sebelumnya)</option>
                                    <?php endif; ?>
                                    <?php foreach ($daftarKelas as $jurusan => $listKelas): ?>
                                        <optgroup label="<?= esc($jurusan); ?>">
                                            <?php foreach ($listKelas as $pilihan): ?>
                                                <option value="<?= esc($pilihan); ?>" <?= ($row['kelas'] === $pilihan) ? 'selected' : ''; ?>>
                                                    <?= esc($pilihan); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                            <button type="button" onclick="closeModal('modalEdit<?= $row['id']; ?>')" class="px-4 py-2 rounded-xl text-slate-600 hover:text-slate-800 hover:bg-slate-200 text-sm font-medium transition">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-semibold shadow-xs hover:shadow transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Create Student Modal -->
    <div id="modalTambah" class="modal-container fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-4 overflow-y-auto" onclick="if(event.target === this) closeModal('modalTambah')">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-100 transform transition-all animate-in fade-in zoom-in-95 duration-200">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-blue-600"></i>
                    <h3 class="font-bold text-slate-900 text-base">Tambah Data Siswa</h3>
                </div>
                <button type="button" onclick="closeModal('modalTambah')" class="text-slate-400 hover:text-slate-600 rounded-lg p-1 focus:outline-none" aria-label="Tutup Modal">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Create Form -->
            <form action="<?= base_url('home/tambah'); ?>" method="POST">
                <?= csrf_field() ?>
                <div class="p-6 space-y-4">
                    <div>
                        <label for="nis" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">NIS</label>
                        <input type="text" name="nis" id="nis" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Masukkan NIS" required>
                    </div>
                    <div>
                        <label for="nama" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                    <div>
                        <label for="kelas" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Kelas / Jurusan</label>
                        <select name="kelas" id="kelas" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white" required>
                            <option value="" disabled selected>-- Pilih Kelas / Jurusan --</option>
                            <?php foreach ($daftarKelas as $jurusan => $listKelas): ?>
                                <optgroup label="<?= esc($jurusan); ?>">
                                    <?php foreach ($listKelas as $pilihan): ?>
                                        <option value="<?= esc($pilihan); ?>"><?= esc($pilihan); ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('modalTambah')" class="px-4 py-2 rounded-xl text-slate-600 hover:text-slate-800 hover:bg-slate-200 text-sm font-medium transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold shadow-xs hover:shadow transition">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="modalProfile" class="modal-container fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-4 overflow-y-auto" onclick="if(event.target === this) closeModal('modalProfile')">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-id-badge text-blue-600"></i>
                    <h3 class="font-bold text-slate-900 text-base">Profil Pengguna</h3>
                </div>
                <button type="button" onclick="closeModal('modalProfile')" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-900 text-white flex items-center justify-center text-xl font-bold mx-auto mb-3 shadow-md">
                    AD
                </div>
                <h4 class="text-base font-bold text-slate-900">Administrator XI RPL</h4>
                <p class="text-xs text-slate-500 mt-0.5">admin.rpl@sekolah.sch.id</p>
                <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Guru Pembimbing RPL
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closeModal('modalProfile')" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div id="modalSettings" class="modal-container fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-4 overflow-y-auto" onclick="if(event.target === this) closeModal('modalSettings')">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-amber-500"></i>
                    <h3 class="font-bold text-slate-900 text-base">Pengaturan Sistem</h3>
                </div>
                <button type="button" onclick="closeModal('modalSettings')" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="p-6 space-y-3 text-sm">
                <div class="flex justify-between items-center py-2 border-b border-slate-100">
                    <span class="text-slate-500">Versi UI Framework</span>
                    <span class="font-semibold text-slate-800">Tailwind CSS (v1.3.0)</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-100">
                    <span class="text-slate-500">Koneksi Database</span>
                    <span class="font-semibold text-emerald-600">db_rpl_siswa</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-slate-500">Limit Baris Tabel</span>
                    <span class="font-semibold text-slate-800">10 data / halaman</span>
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closeModal('modalSettings')" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript Interactions -->
    <script>
        // DOM Elements
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const mobileBackdrop = document.getElementById('mobileBackdrop');

        // Initialize Desktop Sidebar Pin state from localStorage
        function initSidebarState() {
            const isPinned = localStorage.getItem('ci_siswa_sidebar_pinned') === 'true';
            if (isPinned && window.innerWidth >= 1024) {
                sidebar.classList.add('is-pinned');
                mainContent.classList.add('sidebar-pinned');
            }
        }

        // Toggle Desktop Sidebar Pin
        function toggleDesktopSidebar() {
            const isPinned = sidebar.classList.contains('is-pinned');
            if (isPinned) {
                sidebar.classList.remove('is-pinned');
                mainContent.classList.remove('sidebar-pinned');
                localStorage.setItem('ci_siswa_sidebar_pinned', 'false');
            } else {
                sidebar.classList.add('is-pinned');
                mainContent.classList.add('sidebar-pinned');
                localStorage.setItem('ci_siswa_sidebar_pinned', 'true');
            }
        }

        // Toggle Mobile Sidebar Drawer
        function toggleMobileSidebar() {
            const isClosed = sidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                mobileBackdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                mobileBackdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Close Mobile Sidebar
        function closeMobileSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            mobileBackdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Modal Handlers
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Logout Confirmation
        function confirmLogout() {
            if (confirm('Apakah kamu yakin ingin keluar dari sesi ini?')) {
                alert('Sesi Anda telah diakhiri.');
                window.location.href = '<?= base_url(); ?>';
            }
        }

        // Keyboard Shortcuts (Escape to close modals or mobile drawer)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-container:not(.hidden)').forEach(modal => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });
                document.body.classList.remove('overflow-hidden');
                closeMobileSidebar();
            }
        });

        // Initialize on load
        document.addEventListener('DOMContentLoaded', initSidebarState);
    </script>
</body>

</html>