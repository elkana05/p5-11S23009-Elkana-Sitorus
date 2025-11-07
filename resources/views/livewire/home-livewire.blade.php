<div data-bs-theme="{{ $theme }}">
    @push('styles')
        <style>
            /* Tema Gelap */
            [data-bs-theme="dark"] .trix-content,
            [data-bs-theme="dark"] .trix-toolbar {
                background-color: #2b3035;
                color: #f8f9fa;
            }

            /* Tema Terang */
            [data-bs-theme="light"] .trix-content,
            [data-bs-theme="light"] .trix-toolbar {
                background-color: #ffffff;
                color: #212529;
            }

            [data-bs-theme="dark"] .trix-toolbar .trix-button-group {
                border-color: #495057;
            }

            [data-bs-theme="dark"] .trix-toolbar .trix-button {
                color: #f8f9fa;
            }

            [data-bs-theme="dark"] .trix-toolbar .trix-button.trix-active {
                background-color: #495057;
            }
        </style>
    @endpush
    {{-- Judul Halaman dan Sambutan --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-5 fw-bold">Dashboard Keuangan</h1>
            <p class="lead mb-0">Selamat datang kembali, {{ auth()->user()->name }}.</p>
        </div>
        <div class="d-flex align-items-center">
            <x-theme-switcher />
            <div class="dropdown">
                <button class="btn btn-outline-secondary ms-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('auth.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Filter Tanggal untuk Chart --}}
    <div class="card bg-dark-subtle shadow-sm mb-4 rounded-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="startDate" class="form-label">Dari Tanggal</label>
                    <input type="date" id="startDate" class="form-control form-control-dark" wire:model.live="startDate">
                </div>
                <div class="col-md-4">
                    <label for="endDate" class="form-label">Hingga Tanggal</label>
                    <input type="date" id="endDate" class="form-control form-control-dark" wire:model.live="endDate">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary w-100" wire:click="resetDateFilter"><i class="bi bi-arrow-clockwise"></i> Reset Filter</button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Charts --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card bg-dark-subtle mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-pie-chart-fill me-2"></i>Proporsi Keuangan</h5>
                </div>
                <div class="card-body">
                    <div wire:ignore id="financial-pie-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card bg-dark-subtle mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-bar-chart-line-fill me-2"></i>Perbandingan Keuangan</h5>
                </div>
                <div class="card-body">
                    <div wire:ignore id="financial-bar-chart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Ringkasan Saldo --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-dark-subtle shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-arrow-up-circle text-success fs-1 me-3"></i>
                    <div>
                        <small class="text-muted">Total Pemasukan</small>
                        <h5 class="card-title mb-0 fw-bold text-success">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark-subtle shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-arrow-down-circle text-danger fs-1 me-3"></i>
                    <div>
                        <small class="text-muted">Total Pengeluaran</small>
                        <h5 class="card-title mb-0 fw-bold text-danger">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark-subtle shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-wallet2 text-warning fs-1 me-3"></i>
                    <div>
                        <small class="text-muted">Saldo Akhir</small>
                        <h5 class="card-title mb-0 fw-bold text-warning">Rp {{ number_format($balance, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Catatan Keuangan --}}
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="card-title mb-2 mb-md-0"><i class="bi bi-card-list me-2"></i>Catatan Keuangan</h5>
                <div class="d-flex align-items-center">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addTodoModal">
                        <i class="bi bi-plus-circle"></i> Tambah Catatan
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="filterType">
                        <option value="">Semua Jenis</option>
                        <option value="1">Pemasukan</option>
                        <option value="0">Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-9">
                    <input type="search" class="form-control" placeholder="Cari berdasarkan judul..."
                        wire:model.live.debounce.300ms="search">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-hash me-2"></i>#</th>
                            <th><i class="bi bi-card-heading me-2"></i>Judul</th>
                            <th><i class="bi bi-tags-fill me-2"></i>Jenis</th>
                            <th><i class="bi bi-cash-coin me-2"></i>Jumlah</th>
                            <th><i class="bi bi-calendar-event me-2"></i>Tanggal</th>
                            <th><i class="bi bi-gear-fill me-2"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ ($records->currentPage() - 1) * $records->perPage() + $loop->iteration }}</td>
                                <td>{{ $record->title }}</td>
                                <td>
                                    @if ($record->type == 1)
                                        <span class="badge bg-success">Pemasukan</span>
                                    @else
                                        <span class="badge bg-danger">Pengeluaran</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($record->amount, 0, ',', '.') }}</td>
                                <td>{{ $record->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('app.todo.detail', ['todo_id' => $record->id]) }}" wire:navigate
                                        class="btn btn-sm btn-outline-info rounded-pill px-3" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                        wire:click="prepareEditTodo({{ $record->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                        wire:click="prepareDeleteTodo({{ $record->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $records->links() }}
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('components.modals.todos.add')
    @include('components.modals.todos.edit')
    @include('components.modals.todos.delete')

    @script
    <script>
        // Listener global yang hanya perlu diinisialisasi sekali
        document.addEventListener('livewire:initialized', () => {
            // Listener untuk notifikasi (SweetAlert)
            Livewire.on('show-alert', (data) => {
                const eventData = Array.isArray(data) ? data[0] : data;
                Swal.fire({
                    icon: eventData.type,
                    title: eventData.title,
                    text: eventData.message,
                });
            });

            // Listener untuk membuka modal
            Livewire.on('open-modal', (id) => {
                const modalId = Array.isArray(id) ? id[0] : id;
                new bootstrap.Modal(document.getElementById(modalId)).show();
            });

            // Listener untuk menutup modal
            Livewire.on('close-modal', (id) => {
                const modalId = Array.isArray(id) ? id[0] : id;
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById(modalId));
                if (modalInstance) {
                    modalInstance.hide();
                }
            });
        });

        let pieChart;
        let barChart;

        // Listener yang dijalankan setiap kali halaman ini dimuat (termasuk via wire:navigate)
        document.addEventListener("livewire:navigated", () => {
            // --- Inisialisasi Chart ---
            function initCharts() {
                // Fungsi untuk inisialisasi atau update pie chart
                function initPieChart(income, expense) {
                    const pieChartEl = document.querySelector("#financial-pie-chart");
                    if (!pieChartEl) {
                        console.warn('Pie chart element not found. Skipping initialization.');
                        return;
                    }

                    const seriesData = [Number(income) || 0, Number(expense) || 0];
                    const chartOptions = {
                        series: seriesData,
                        chart: { type: 'pie', height: 350 },
                        labels: ['Pemasukan', 'Pengeluaran'],
                        colors: ['#198754', '#dc3545'],
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        },
                        dataLabels: {
                            formatter: function(val, opts) {
                                const seriesValue = opts.w.globals.series[opts.seriesIndex];
                                return "Rp " + seriesValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: { width: '100%' },
                                legend: { position: 'bottom' }
                            }
                        }]
                    };

                    if (pieChart) pieChart.destroy();
                    pieChart = new ApexCharts(pieChartEl, chartOptions);
                    pieChart.render();
                }

                // Fungsi untuk inisialisasi atau update bar chart
                function initBarChart(income, expense) {
                    const barChartEl = document.querySelector("#financial-bar-chart");
                    if (!barChartEl) {
                        console.warn('Bar chart element not found. Skipping initialization.');
                        return;
                    }

                    // Tentukan warna teks berdasarkan tema yang aktif
                    const currentTheme = localStorage.getItem('theme') || 'dark';
                    const textColor = currentTheme === 'dark' ? '#f8f9fa' : '#373d3f';
                    const barChartOptions = {
                        series: [{
                            name: 'Jumlah',
                            data: [Number(income) || 0, Number(expense) || 0]
                        }],
                        chart: { type: 'bar', height: 350 },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                distributed: true,
                            },
                        },
                        dataLabels: { enabled: false },
                        colors: ['#198754', '#dc3545'],
                        xaxis: { categories: ['Pemasukan', 'Pengeluaran'] },
                        theme: {
                            mode: currentTheme
                        },
                        yaxis: {
                            labels: {
                                formatter: (val) => "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."),
                                style: {
                                    colors: textColor
                                }
                            }
                        },
                        xaxis: {
                            categories: ['Pemasukan', 'Pengeluaran'],
                            labels: { style: { colors: textColor } }
                        },
                        legend: { show: false },
                        tooltip: {
                            y: {
                                formatter: (val) => "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                            }
                        }
                    };

                    if (barChart) barChart.destroy();
                    barChart = new ApexCharts(barChartEl, barChartOptions);
                    barChart.render();
                }
                // Inisialisasi pertama kali saat halaman dimuat
                initPieChart(@js($totalIncome), @js($totalExpense));
                initBarChart(@js($totalIncome), @js($totalExpense));

                // Listener untuk memperbarui chart saat data berubah dari Livewire
                Livewire.on('update-charts', (event) => {
                    const income = Array.isArray(event) ? event[0].totalIncome : event.totalIncome;
                    const expense = Array.isArray(event) ? event[0].totalExpense : event.totalExpense;
                    const newSeriesData = [Number(income) || 0, Number(expense) || 0];

                    if (pieChart && barChart) { // Line chart tidak diupdate oleh filter ini
                        pieChart.updateSeries(newSeriesData, true);
                        barChart.updateSeries([{ data: newSeriesData }], true);
                    }
                });
            }

            // --- Inisialisasi Pengalih Tema ---
            function initThemeSwitcher() {
                const themeToggleBtn = document.getElementById('theme-toggle');
                if (!themeToggleBtn) return;

                const darkIcon = document.getElementById('theme-toggle-dark-icon');
                const lightIcon = document.getElementById('theme-toggle-light-icon');
                const htmlElement = document.documentElement;

                const applyTheme = (theme) => {
                    htmlElement.setAttribute('data-bs-theme', theme);
                    if (theme === 'dark') {
                        lightIcon.classList.add('d-none');
                        darkIcon.classList.remove('d-none');
                    } else {
                        darkIcon.classList.add('d-none');
                        lightIcon.classList.remove('d-none');
                    }
                    localStorage.setItem('theme', theme);
                };

                const storedTheme = localStorage.getItem('theme') || 'dark';
                applyTheme(storedTheme);

                themeToggleBtn.addEventListener('click', () => {
                    const newTheme = htmlElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                    applyTheme(newTheme);
                    @this.dispatch('theme-changed');
                });
            }

            // Jalankan semua inisialisasi
            initCharts();
            initThemeSwitcher();
        });
    </script>
    @endscript
</div>