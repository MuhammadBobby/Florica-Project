@props(['order'])

<div id="review-order-modal-{{ $order->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-60 justify-center items-center w-full md:inset-0 h-full">

    <div class="relative p-4 w-full max-w-3xl max-h-full">

        <div class="bg-white rounded-base shadow-xl p-6">

            <div class="flex justify-between items-center mb-5">

                <h3 class="text-xl font-semibold">
                    Beri Ulasan Pesanan
                </h3>

                <button type="button" data-modal-hide="review-order-modal-{{ $order->id }}">
                    ✕
                </button>

            </div>

            <form action="{{ route('my-orders.review') }}" method="POST">

                @csrf

                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <div class="space-y-5">

                    @foreach ($order->items as $item)
                        <div class="border rounded-base p-4">

                            <div class="flex gap-4">

                                <img src="{{ asset('storage/' . ($item->product?->primaryImage?->image_url ?? 'products/default_image.webp')) }}"
                                    class="w-20 h-20 rounded-base object-cover">

                                <div>

                                    <h5 class="font-medium">
                                        {{ $item->product_name }}
                                    </h5>

                                    <p class="text-sm text-body">
                                        Qty:
                                        {{ $item->quantity }}
                                    </p>

                                </div>

                            </div>

                            <input type="hidden" name="reviews[{{ $item->id }}][product_id]"
                                value="{{ $item->product_id }}">


                            <div class="mt-4">
                                <label class="block mb-2 font-medium">
                                    Rating
                                </label>

                                <input type="hidden" name="reviews[{{ $item->id }}][rating]"
                                    id="rating-input-{{ $item->id }}" value="5">

                                <div class="flex gap-1 rating-stars" data-item="{{ $item->id }}">

                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button" class="star-btn text-3xl text-yellow-400"
                                            data-rating="{{ $i }}">
                                            ★
                                        </button>
                                    @endfor

                                </div>

                            </div>

                            <div class="mt-3">

                                <textarea name="reviews[{{ $item->id }}][review]" rows="3" placeholder="Bagikan pengalaman Anda..."
                                    class="w-full border rounded-base"></textarea>

                            </div>

                        </div>
                    @endforeach

                </div>

                <button type="submit" class="mt-5 px-5 py-2 bg-primary text-white rounded-base">

                    Kirim Semua Ulasan

                </button>

            </form>

        </div>

    </div>

</div>
