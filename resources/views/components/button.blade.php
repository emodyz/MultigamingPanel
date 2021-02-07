<button {{ $attributes->merge(['type' => 'submit', 'class' => 'disabled:cursor-not-allowed disabled:opacity-75 inline-flex items-center px-4 py-2 bg-gray-800 border
    border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900
    focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-400 transition ease-in-out duration-150
    dark:text-gray-100 dark:bg-indigo-500 dark:hover:bg-indigo-400 dark:active:bg-indigo-500 dark:focus:border-indigo-400
    dark:focus:ring-indigo-400 dark:disabled:bg-gray-700']) }}>
    {{ $slot }}
</button>
