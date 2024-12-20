<div class="z-10">
    @php
        $color = match ($value) {
            'A' => 'btn-success',
            'B' => 'btn-info',
            'C' => 'btn-secondary',
            'D' => 'btn-warning',
            'E' => 'btn-error',
            default => 'btn-outline',
        };
    @endphp
    <button onclick="openModal('{{ $id }}_{{ $column }}')" class="btn mx-auto {{$color}}">{{ $value }}</button>
    <form action="{{ route('nilaikaryawan.update', [$id, $column]) }}" method="POST" class="text-center">
        @csrf
        @method('PATCH')
        <!-- Modal -->
        <div id="modal{{ $id }}_{{ $column }}" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden z-50">
            <input type="hidden" name="column" value="{{ $column }}">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg p-6 w-64">
                    <h3 class="text-lg font-bold mb-4">Pilih Grade {{ $column }}</h3>
                    <div class="grid grid-cols-5 gap-2">
                        @foreach(['A', 'B', 'C', 'D', 'E'] as $grade)
                            <button type="submit" class="btn btn-sm w-full"
                                onclick="document.getElementById('grade{{ $id }}_{{ $column }}').value = '{{ $grade }}'">
                                {{ $grade }}
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" id="grade{{ $id }}_{{ $column }}" name="value" value="">
                    <button type="button" onclick="closeModal('{{ $id }}_{{ $column }}')"
                        class="btn btn-sm btn-outline mt-4 w-full">Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function openModal(id) {
        document.getElementById('modal' + id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById('modal' + id).classList.add('hidden');
    }
</script>