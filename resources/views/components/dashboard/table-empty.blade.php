 <div
     class="flex flex-col items-center justify-center py-20 border border-dashed border-default rounded-base bg-neutral-primary-soft">

     {{-- Icon --}}
     <svg class="w-16 h-16 text-body mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
             d="M3 7h18M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 11v5M15 11v5M10 4h4a1 1 0 0 1 1 1v2H9V5a1 1 0 0 1 1-1Z" />
     </svg>

     {{-- Title --}}
     <h3 class="text-xl font-semibold text-heading">
         {{ $title }}
     </h3>

     {{-- Description --}}
     <p class="mt-2 text-sm text-body text-center max-w-md">
         {{ $slot }}
     </p>
 </div>
