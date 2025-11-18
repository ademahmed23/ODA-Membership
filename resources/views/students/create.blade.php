<div wire:ignore.self class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                        <input type="text" class="form-control" placeholder="Full name" wire:model="name">
                        @error('name') <span class="error">{{ $message }}</span> @enderror

                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input type="email" class="form-control" placeholder="name@example.com" wire:model="email">
                        @error('email') <span class="error">{{ $message }}</span> @enderror

                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Phone</label>
                        <input type="text" class="form-control" placeholder="09......." wire:model="mobile">
                        @error('mobile') <span class="error">{{ $message }}</span> @enderror

                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput">Image</label>

                        <input type="file" wire:model="image">
                        @error('image') <span class="error">{{ $message }}</span> @enderror

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                <button type="button" wire:click.prevent="store" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
