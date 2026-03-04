@props(['idea' => new \App\Models\Idea()])

<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}"
         title="{{ $idea->exists ? 'Edit Idea' : 'Create New Idea' }}">
    <form x-data="{ status: @js(old('status', $idea->status->value)),
                   newLink: '',
                   links: @js(old('links', $idea->links ?? [])),
                   newStep: '',
                   steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed']))),
                  }"
          method="POST"
          action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
          {{--                  enctype="multipart/form-data"--}}
          x-bind:enctype="image ? 'multipart/form-data' : false">
        @csrf

        @if($idea->exists)
            @method('PATCH')
        @endif

        <div class="space-y-6">
            {{-- Title--}}
            <x-form.field name="title" label="Title" placeholder="Enter an idea for a title"
                          :value="$idea->title" required/>
            {{-- Status --}}
            <div class="space-y-2">
                <label for="status" class="label">Status</label>
                <div class="flex gap-x-3">
                    @foreach(App\IdeaStatus::cases() as $status)
                        <button type="button"
                                @click="status = '{{ $status->value }}'"
                                data-test="idea-status-{{ $status->value }}"
                                class="btn flex-1 h-10"
                                :class="{'btn-outlined': status !== '{{ $status->value }}'}">
                            {{ $status->label() }}
                        </button>
                    @endforeach
                    <input type="hidden" name="status" :value="status">
                </div>
                <x-form.error name="status"/>
            </div>
            {{--Description--}}

            <x-form.field name="description" label="Description" type="textarea"
                          :value="$idea->description" placeholder="Describe your idea..."/>

            {{-- Image --}}
            <div class="space-y-2">
                <label for="image" class="label">Featured Image</label>
                @if($idea->image_path)
                    <div class="space-y-2">
                        <img src="{{ asset('storage/' . $idea->image_path) }}"
                             alt="{{ $idea->title }}" class="w-full h-48 object-cover rounded-lg"/>
                        <button class="btn btn-outlined h-10 w-full"
                                form="delete-image-form">Remove Image
                        </button>
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*"/>
                <x-form.error name="image"/>
            </div>
            {{-- Steps--}}
            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Actionable Steps</legend>
                    <template x-for="(step, index) in steps" :key="step.id || index">
                        <div class="flex gap-x-2 items-center">
                            <input class="input" :name="`steps[${index}][description]`" x-model="step.description">
                            <input type="hidden" :name="`steps[${index}][completed]`"
                                   x-model="step.completed ? '1': '0'" readonly>
                            <button type="button"
                                    @click="steps.splice(index, 1)"
                                    aria-label="Remove step Button"
                                    class="form-muted-icon">
                                <x-icons.close/>
                            </button>
                        </div>
                    </template>
                    <div class="flex gap-x-2 items-center">
                        <input x-model="newStep"
                               id="new-step"
                               data-test="new-step"
                               autocomplete="url"
                               placeholder="What needs to be done?"
                               class="input flex-1"
                               spellcheck="false"/>

                        <button type="button"
                                @click="
                                steps.push({description: newStep.trim(), completed: false});
                                newStep = '';
                                "
                                :disabled="newStep.trim().length === 0"
                                data-test="submit-new-step-button"
                                aria-label="Add new Step Button"
                                class="form-muted-icon">
                            <x-icons.close class="rotate-45"/>
                        </button>
                    </div>
                    <x-form.error name="steps"/>
                </fieldset>
            </div>
            {{--Links--}}
            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Links</legend>
                    <template x-for="(link, index) in links" :key="`${link}-${index}`">
                        <div class="flex gap-x-2 items-center">
                            <input class="input" name="links[]" :value="link">
                            <button type="button"
                                    @click="links.splice(index, 1)"
                                    aria-label="Remove link Button"
                                    class="form-muted-icon">
                                <x-icons.close/>
                            </button>
                        </div>
                    </template>
                    <div class="flex gap-x-2 items-center">
                        <input x-model="newLink"
                               type="url"
                               id="new-link"
                               data-test="new-link"
                               autocomplete="url"
                               placeholder="https://example.com"
                               class="input flex-1"
                               spellcheck="false"/>

                        <button type="button"
                                @click="links.push(newLink.trim()); newLink = '';"
                                :disabled="newLink.trim().length === 0"
                                data-test="submit-new-link-button"
                                aria-label="Add new link Button"
                                class="form-muted-icon">
                            <x-icons.close class="rotate-45"/>
                        </button>
                    </div>
                    <x-form.error name="Links"/>
                </fieldset>
            </div>
            <div class="flex justify-end gap-x-5">
                <button type="button"
                        @click="$dispatch('close-modal', '{{ $idea->exists ? 'edit' : 'create' }}-idea')"
                >Cancel
                </button>
                <button class="btn" data-test="button-{{ $idea->exists ? 'edit' : 'create' }}-idea"
                        type="submit">{{ $idea->exists ? 'Update' : 'Create' }}</button>
            </div>
        </div>
    </form>
    {{--Delete image form--}}
    @if($idea->image_path)
        <form action="{{ route('idea.image.destroy', $idea) }}" method="POST" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>
