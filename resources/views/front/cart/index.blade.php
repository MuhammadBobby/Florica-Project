<x-layouts.home title="carts">

    <div class="max-w-5xl mx-auto p-5 border border-default rounded-base shadow-xl mb-8">
        <div id="cart-form">
            <div class="space-y-4">
                @forelse($cart?->items ?? [] as $item)
                    {{-- Cart Item --}}
                    <div class="cart-item flex gap-4 p-4 bg-white rounded-base border border-default hover:bg-secondary/20 cursor-pointer transition"
                        data-id="{{ $item->id }}">

                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}"
                            class="cart-checkbox mt-8 text-primary">

                        <img src="{{ asset('storage/' . $item->product->primaryImage?->image_url) }}"
                            class="w-24 h-24 object-cover rounded-base">

                        <div class="flex-1">

                            <h3 class="font-semibold">
                                {{ $item->product->name }}
                            </h3>

                            <p class="text-primary font-bold">
                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            </p>

                            <div class="mt-3">

                                <form action="{{ route('cart.update', $item) }}" method="POST"
                                    id="cart-form-{{ $item->id }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="number" name="quantity" min="1" value="{{ $item->quantity }}"
                                        onchange="this.form.submit()" class="cart-qty border rounded px-2 py-1 w-20">
                                </form>

                            </div>

                        </div>

                        <form action="{{ route('cart.destroy', $item) }}" method="POST" class="delete-form-cart">

                            @csrf
                            @method('DELETE')

                            <button class="text-red-500 hover:text-red-700 font-semibold font-montserrat">
                                Hapus
                            </button>

                        </form>

                    </div>

                @empty

                    <div class="bg-white border border-dashed border-default rounded-base p-12 text-center">

                        <div class="text-6xl mb-4">
                            🛒
                        </div>

                        <h3 class="text-lg font-semibold text-heading">
                            Keranjang masih kosong
                        </h3>

                        <p class="text-body mt-2">
                            Tambahkan produk favoritmu terlebih dahulu.
                        </p>

                        <a href="{{ route('products') }}"
                            class="inline-flex mt-5 px-5 py-2.5 bg-primary text-white rounded-base">

                            Belanja Sekarang

                        </a>

                    </div>
                @endforelse

            </div>

            @if ($cart && $cart->items->count())
                <div
                    class="sticky bottom-5 mt-8 bg-white border border-default rounded-base p-4 flex justify-between items-center">

                    <div>
                        <h4 class="font-semibold">
                            Pilih produk yang ingin dibeli
                        </h4>

                        <p class="text-sm text-body">
                            Bisa checkout beberapa produk sekaligus
                        </p>
                    </div>

                    <button id="checkout-selected" class="bg-primary text-white px-6 py-3 rounded-base">
                        Checkout Terpilih
                    </button>

                </div>
            @endif
        </div>
    </div>

    <form id="checkout-form" action="{{ route('checkout.index') }}" method="POST" class="hidden">
        @csrf

        <input type="hidden" name="items" id="selected-items">
    </form>


    {{-- Kembali --}}
    <a href="{{ route('products') }}"
        class="fixed top-24 left-10 z-50
           flex items-center gap-2
           px-4 py-3
           bg-primary text-white
           rounded-full
           shadow-lg
           border border-gray-200
           hover:shadow-xl
           hover:-translate-y-0.5
           transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>

        <span class="text-sm font-medium">
            Kembali
        </span>
    </a>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const selectedItems = new Set();

                // Update selected items
                document.querySelectorAll('.cart-item').forEach(card => {

                    const checkbox = card.querySelector('.cart-checkbox');

                    card.addEventListener('click', (e) => {
                        if (
                            e.target.tagName === 'INPUT' ||
                            e.target.tagName === 'BUTTON'
                        ) {
                            return;
                        }

                        checkbox.checked = !checkbox.checked;
                        updateSelected(card.dataset.id, checkbox.checked);
                        updateCardStyle(card, checkbox.checked);

                    });

                    checkbox.addEventListener('change', () => {
                        updateSelected(card.dataset.id, checkbox.checked);
                        updateCardStyle(card, checkbox.checked);
                    });
                });

                // Func to update selected or remove
                function updateSelected(id, checked) {
                    if (checked) {
                        selectedItems.add(id);
                    } else {
                        selectedItems.delete(id);
                    }
                }


                // Func to Update card item style
                function updateCardStyle(card, checked) {
                    if (checked) {
                        card.classList.remove(
                            'bg-white',
                        )
                        card.classList.add(
                            'border-primary',
                            'bg-secondary/20'
                        );
                    } else {
                        card.classList.remove(
                            'border-primary',
                            'bg-primary/10'
                        );
                        card.classList.add(
                            'bg-white'
                        );
                    }
                }

                // Checkout
                document.getElementById('checkout-selected').addEventListener('click', () => {
                    if (!selectedItems.size) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Pilih Produk',
                            text: 'Silakan pilih minimal 1 produk.'
                        });

                        return;
                    }

                    // Update selected items & submit
                    document.getElementById('selected-items').value =
                        JSON.stringify([...selectedItems]);

                    document.getElementById('checkout-form').submit();
                });
            });
        </script>
    @endpush

</x-layouts.home>
