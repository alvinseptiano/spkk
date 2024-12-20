<div class="dropdown dropdown-bottom">
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
    <div tabindex="0" role="button" class="btn mx-auto {{$color}}" onclick="toggleDropdown(event)">{{ $value }}</div>
    <ul tabindex="0" class="dropdown-content items-center menu bg-base-100 rounded-box z-[1] w-24 shadow hidden">
        @foreach(['A', 'B', 'C', 'D', 'E'] as $grade)
            <li>
                <form action="{{ route('nilaikaryawan.update', $id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="column" value="{{ $column }}">
                    <input type="hidden" name="value" value="{{ $grade }}">
                    <button type="submit">
                        {{ $grade }}
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
</div>

<script>
    function toggleDropdown(event) {
        const dropdownContent = event.currentTarget.nextElementSibling;
        dropdownContent.classList.toggle('hidden');
    }

    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdown-content');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target) && !dropdown.previousElementSibling.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>