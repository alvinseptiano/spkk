<x-app-layout>
    <x-toast />
    <div class="container pt-3">
        <h1 class="text-center font-extrabold text-xl md:text-2xl">List Karyawan</h1>
        <div class="container flex justify-end items-center pt-4">
            <div class="flex justify-start items-center ml-3 mr-10">
                <form action="{{ route('listkaryawansearch') }}" method="GET">
                    <input type="hidden" name="view" value="{{ 'biokaryawan' }}">
                    <input type="text" name="query" class="rounded" placeholder="Cari Karyawan">
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="flex items-center">
            <a href="{{ route('listkaryawan.create') }}" class="btn btn-success min-w-48">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Karyawan
                </a>
            </div>
        </div>

        <div class="container pt-4 pb-5">
            <div class="table-container" style="max-height: calc(100vh - 250px); overflow-y: auto; padding-bottom: 1rem;">
                <table class="table table-bordered min-w-full">
                    <thead class="bg-gray-100 sticky top-0">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Tanggal Lahir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <h2 class="text-lg gap-5 inline-flex">
                                        {{ $employee->name }}
                                        @if($employee->role == 'karyawan')
                                            <span class="badge badge-neutral badge-lg">{{ $employee->role }}</span>
                                        @elseif($employee->role == 'manager')
                                            <span class="badge badge-accent badge-lg">{{ $employee->role }}</span>
                                        @elseif($employee->role == 'admin')
                                            <span class="badge badge-warning badge-lg">{{ $employee->role }}</span>
                                        @endif
                                    </h2>
                                </td>
                                <td>{{ $employee->dob->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('listkaryawan.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('listkaryawan.destroy', $employee->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-error" onclick="return confirm('Apakah kamu yakin menghapus Karyawan ?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>