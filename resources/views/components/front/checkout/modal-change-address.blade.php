 <div id="address-modal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50">
     <div class="relative w-full max-w-2xl p-4">
         <div class="bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">

             <div class="flex justify-between items-center mb-5">
                 <h3 class="text-xl font-bold">
                     Pilih Alamat
                 </h3>

                 <button type="button" id="close-address-modal" class="text-gray-500">
                     ✕
                 </button>
             </div>

             <div class="space-y-3 max-h-[60vh] overflow-auto">

                 @foreach (auth()->user()->addresses as $address)
                     <button type="button"
                         class="select-address w-full text-left border rounded-base p-4 hover:border-primary hover:bg-pink-50"
                         data-id="{{ $address->id }}">
                         <div class="font-semibold">
                             {{ $address->recipient_name }}
                         </div>

                         <div class="text-sm text-body">
                             {{ $address->recipient_phone }}
                         </div>

                         <div class="mt-2">
                             {{ $address->address }}
                         </div>

                         <div class="text-sm mt-2">
                             {{ $address->district }},
                             {{ $address->city }},
                             {{ $address->province }},
                             ID
                             {{ $address->postal_code }}
                         </div>

                     </button>
                 @endforeach
             </div>
         </div>
     </div>
 </div>
