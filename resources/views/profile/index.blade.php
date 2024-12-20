<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.view-user-grade-form')
                </div>
            </div>

            <div class="sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="sm:p-8 bg-white  shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
