<section id="header" class="flex justify-between items-center gap-5">
    <div class="w-full">
        {{-- Search Product --}}
        <form class="max-w-md">
            <label for="search" class="block mb-2.5 text-lg font-medium text-primary sr-only ">Cari produk...</label>
            <div class="relative">
                <div class="absolute inset-y-0 insert-s-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-5 h-5 text-primary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="search"
                    class="block p-3 ps-12 bg-secondary border border-default-medium text-primary text-lg rounded-full focus:ring-primary focus:border-primary shadow-xs placeholder:text-primary"
                    placeholder="Cari produk..." required />
            </div>
        </form>


        {{-- Heading --}}

        <header class="mt-10 text-montserrat">
            <h1 class="text-9xl font-light -tracking-wider">Florica</h1>
            <h1 class="text-9xl font-light -tracking-wider -mt-3">Blooms</h1>

            <div class="ms-2 max-w-3xl">
                <p class="text-3xl font-light tracking-wider">Make Every Moment Bloom</p>
                <p class="text-xl font-light mt-5 -tracking-wide">Lorem ipsum dolor sit amet consectetur adipisicing
                    elit. Officiis
                    quod eos ad obcaecati vero natus,
                    maiores voluptates excepturi, tempore magni fugit ut sequi nihil adipisci optio illo. Fugiat,
                    aliquam
                    rem.</p>
            </div>
            </he>
    </div>

    <div class="w-fit flex flex-col justify-center items-center gap-3">
        <img src="/assets/elements/blooms.webp" alt="Blooms" class="w-[80%] mx-auto">

        <button type="button"
            class="text-xl text-primary tracking-widest bg-secondary box-border border border-transparent hover:bg-pink-300 focus:ring-4 focus:ring-pink-200 shadow-xs leading-5 rounded-full px-4 py-2.5 mt-5 focus:outline-none">
            Lihat produk >
        </button>
    </div>
</section>
