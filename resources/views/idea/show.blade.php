<x-layout>
    <div class="py-8 max-w-4-xl mx-auto">
     <div class="flex justify-between">
        <a class="flex items-center gap-x-2 text-sm font-medium"
            href="{{ route('idea.index') }}">
            <x-icons.arrow-back />Back to Ideas</a>
     </div>
        <h1 class="font-bold text-4xl">{{ $idea->title }}</h1>

    <x-card class="mt-6">
        <div class="text-foreground max-w-none cursor-pointer">{{ $idea->description }}</div>
    </x-card>
    </div>
</x-layout>
