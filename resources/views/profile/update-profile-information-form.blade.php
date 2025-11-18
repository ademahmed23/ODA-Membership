<x-jet-form-section submit="updateProfileInformation">
    <div class="row">
        <div class="col s12 m4 l4">
            <div class="card">
                <div class="card-header card-header-primary">

                    <x-slot name="title" class="card-title">
                        {{ __('Profile Information') }}
                    </x-slot>

                    <x-slot name="description" class="card-category">
                        {{ __('Update your account\'s profile information and email address.') }}
                    </x-slot>

                </div>


                <div class="card-content">

                    <x-slot name="form">
                        <!-- Profile Photo -->


                        {{-- <span class="card-title">Card Title</span>
                        <p>I am a very simple card. I am good at containing small bits of information.
                            I am convenient because I require little markup to use effectively.</p> --}}

                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                            <!-- Profile Photo File Input -->
                            <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                            <x-jet-label for="photo" value="{{ __('Photo') }}" />

                            <!-- Current Profile Photo -->
                            <div class="mt-2" x-show="! photoPreview">
                                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                            </div>

                            <!-- New Profile Photo Preview -->
                            <div class="mt-2" x-show="photoPreview" style="display: none;">
                                <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center" x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                </span>
                            </div>

                            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                                {{ __('Select A New Photo') }}
                            </x-jet-secondary-button>

                            @if ($this->user->profile_photo_path)
                            <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                                {{ __('Remove Photo') }}
                            </x-jet-secondary-button>
                            @endif

                            <x-jet-input-error for="photo" class="mt-2" />
                        </div>
                        @endif

                        <!-- Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label class="form-contro" for="name" value="{{ __('Name') }}" />

                            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label class="form-contro" for="email" value="{{ __('Email') }}" />
                            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
                            <x-jet-input-error for="email" class="mt-2" />
                        </div>

                        {{-- <div class="card-action">
            <a href="#" class="btn blue lighten-1">This is a link</a>
            <a href="#" class="btn blue darken-1">This is a link</a>
        </div> --}}


                    </x-slot>



                    <x-slot name="actions">
                        <x-jet-action-message class="mr-3" on="saved">
                            {{ __('Saved.') }}
                        </x-jet-action-message>

                        {{-- <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
                        </x-jet-button> --}}

                        <button class="btn btn-primary" wire:loading.attr="disabled" wire:target="photo">
                            Save
                        </button>
                    </x-slot>
                </div>

            </div>
        </div>
    </div>

</x-jet-form-section>
