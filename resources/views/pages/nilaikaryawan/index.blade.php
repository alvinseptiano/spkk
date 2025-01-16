<?php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();

?>
<x-app-layout>
    <x-toast />

    <div class="container pt-3 bg-light">
        <h1 class="text-center font-extrabold text-xl md:text-2xl">Penilaian Karyawan</h1>

        <div class="container flex justify-end items-center pt-4">
            <div class="flex justify-start items-center ml-3 mr-5">
                <form action="{{ route('nilaikaryawansearch') }}" method="GET">
                    <input type="text" name="query" class="rounded outline-gray-300" placeholder="Cari Karyawan">
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('hasil.index') }}" class="btn bg-success min-w-48">
                    <i class="bi bi-bar-chart-fill"></i>
                    Hasil Akhir
                </a>
            </div>
        </div>

        <h1>
            @if(empty($query))
            @else
                Hasil pencarian untuk "{{ $query }}"
            @endif
        </h1>

        <div class="container pt-4 pb-5">
            <div class="table-container" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                <table class="table table-zebra table-bordered min-w-full h-full">
                    <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 20%;">
                                <div class="flex items-center">
                                    Nama
                                    <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                        </svg></a>
                                </div>
                            </th>
                            <th style="width: 10%;">Absensi</th>
                            <th style="width: 10%;">Kebersihan</th>
                            <th style="width: 10%;">Loyalitas</th>
                            <th style="width: 10%;">Perilaku</th>
                            <th style="width: 10%;">Peringatan</th>
                            <th style="width: 10%;">Kinerja</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($employees as $employee)
                            <tr class="items-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-bold uppercase">{{ $employee->name }}</td>
                                <td>
                                    <x-dropdown-grade :value="$employee->absensi" :column="'absensi'" :id="$employee->id" :role="$employee->role" :adminRole="$user->role" />
                                </td>
                                <td>
                                    <x-dropdown-grade :value="$employee->kebersihan" :column="'kebersihan'" :role="$employee->role" :adminRole="$user->role"
                                        :id="$employee->id" />
                                </td>
                                <td>
                                    <x-dropdown-grade :value="$employee->loyalitas" :column="'loyalitas'" :role="$employee->role" :adminRole="$user->role"
                                        :id="$employee->id" />
                                </td>
                                <td>
                                    <x-dropdown-grade :value="$employee->perilaku" :column="'perilaku'" :role="$employee->role" :adminRole="$user->role"
                                        :id="$employee->id" />
                                </td>
                                <td>
                                    <x-dropdown-grade :value="$employee->peringatan" :column="'peringatan'" :role="$employee->role" :adminRole="$user->role"
                                        :id="$employee->id" />
                                </td>
                                <td>
                                    <x-dropdown-grade :value="$employee->kinerja" :column="'kinerja'" :id="$employee->id" :role="$employee->role" :adminRole="$user->role" />

                                </td>
                                <td>
                                    <form action="{{ route('listkaryawan.destroy', $employee->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-error text-error-content"
                                            onclick="return confirm('Apakah kamu yakin menghapus Karyawan ?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Select the alert element
                const alert = document.getElementById('success-alert');

                if (alert) {
                    // Set a timeout to hide the alert after 1 minute (60000ms)
                    setTimeout(() => {
                        alert.style.transition = 'opacity 0.5s'; // Optional fade-out effect
                        alert.style.opacity = '0'; // Fade out the element

                        setTimeout(() => {
                            alert.remove(); // Remove the element after fading out
                        }, 500); // Wait for fade-out transition
                    }, 3000); // Wait 1 minute
                }
            });
            
            if
        </script>
    @endpush
</x-app-layout>
