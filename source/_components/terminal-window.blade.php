<div class="rounded-br-md rounded-bl-md  shadow-md shadow-purple-800">
    <div
        class="border-4 border-black justify-between items-center py-1 px-1 text-xl text-white 
                title text-lg bg-gradient-to-tr from-gray-800 via-gray-700 to-gray-800
    ">
        <div class="flex justify-between gap-2 items-center pl-1">
            <div class="flex gap-3 items-center">
                <span class="fa-solid fa-terminal"></span>
                <p class="text-white">{{ $title }}</p>
            </div>
            <span class="fa-solid fa-{{ $icon }}"></span>
        </div>

    </div>
    <div class="p-1 text-verde rounded-br-md rounded-bl-md 
                bg-gradient-to-b from-black/90 via-black/90 to-black/90">
        {{ $slot }}
    </div>
</div>
