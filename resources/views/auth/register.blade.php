<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registerForm" onsubmit="return validateAge()">
        @csrf
        <div class="gap-8">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Date of Birth Field -->
            <div>
                <x-input-label for="dob" :value="__('Tanggal Lahir')" />
                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" required />
                <p id="ageError" class="text-red-500 text-sm mt-1" style="display: none;">
                    Harus berumur 18 keatas untuk melakukan registrasi.
                </p>
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm dark: hover:text-gray-900 dark:hover: rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button class="ms-4" id="registerButton">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>

<script>
    function validateAge() {
        const dobInput = document.getElementById('dob');
        const ageError = document.getElementById('ageError');
        const registerButton = document.getElementById('registerButton');

        // Get the entered date
        const dob = new Date(dobInput.value);
        const today = new Date();

        // Calculate age
        let age = today.getFullYear() - dob.getFullYear();
        const monthDiff = today.getMonth() - dob.getMonth();

        // Adjust age if birthday hasn't occurred this year
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        // Check if age is valid
        if (age < 18) {
            ageError.style.display = 'block';
            dobInput.focus();
            return false;
        }

        // Hide error message if previously shown
        ageError.style.display = 'none';
        return true;
    }

    // Add event listener to validate on date change
    document.getElementById('dob').addEventListener('change', function () {
        validateAge();
    });
</script>