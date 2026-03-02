@props(['name', 'title'])
<div x-data="{ show: false, name: @js($name) }"
     @open-modal.window="if($event.detail === name) show = true"
     @close-modal.window="if($event.detail === name) show = false"
     @keydown.escape.window="show = false"
     x-cloak>

	<!-- Backdrop -->
	<div x-show="show"
	     @click="show = false"
	     x-transition.opacity.duration.200ms
	     class="fixed inset-0 z-40 bg-black/50 backdrop-blur-xs"
	     style="display: none;"
	     aria-hidden="true"></div>

	<!-- Modal Content -->
	<div x-show="show"
	     x-transition:enter="transition ease-out duration-200"
	     x-transition:enter-start="opacity-0 -translate-y-4 -translate-x-4"
	     x-transition:enter-end="opacity-100"
	     x-transition:leave="transition ease-in duration-150"
	     x-transition:leave-start="opacity-100"
	     x-transition:leave-end="opacity-0 -translate-y-4 -translate-x-4"
	     @click.stop
	     class="fixed inset-0 z-50 flex items-center justify-center pointer-events-none"
	     style="display: none;"
	     role="dialog"
	     aria-modal="true"
	     aria-labelledby="modal-{{ $name }}-title"
	     :aria-hidden="!show"
	     tabindex="-1">
		<x-card class="pointer-events-auto shadow-xl max-w-2xl w-full max-h-[80dvh] overflow-auto">
			<div class="flex justify-between items-center">
				<h2 id="modal-{{ $name }}-title" class="text-xl font-blod">{{ $title }}</h2>
				<button @click="show = false" aria-label="Close modal">
					<x-icons.close/>
				</button>
			</div>
			<div class="mt-4">
				{{ $slot }}
			</div>
		</x-card>
	</div>
</div>
