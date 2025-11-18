<div wire:ignore.self class="modal fade" id="updateStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <input type="hidden" name="id" wire:model="student_id" />
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Fname" wire:model="name">
                        @error('name') <span class="error">{{ $message }}</span> @enderror

                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" wire:model="email">
                        @error('email') <span class="error">{{ $message }}</span> @enderror


                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Phone</label>
                        <input type="text" name="mobile" class="form-control" placeholder="09......." wire:model="mobile">
                        @error('mobile') <span class="error">{{ $message }}</span> @enderror


                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Image</label>
                        <input type="file" name="image" classs="form-control" wire:model="image">
                        @error('image') <span class="error">{{ $message }}</span> @enderror

                    </div>




                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
