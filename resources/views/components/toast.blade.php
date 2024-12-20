@if (session('success'))
    <div id="toast-success"
        class="z-10 fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4  bg-white rounded-lg shadow"
        role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
        <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-white  hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8"
            onclick="closeToast()" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Automatically hide the toast after 5 seconds (5000ms)
            setTimeout(() => {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    toast.style.transition = 'opacity 0.5s ease';
                    toast.style.opacity = '0'; // Fade out
                    setTimeout(() => toast.remove(), 300); // Remove after fade-out
                }
            }, 5000);
        });

        // Close toast manually when the close button is clicked
        function closeToast() {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.style.transition = 'opacity 0.5s ease';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }
        }
    </script>
@endif