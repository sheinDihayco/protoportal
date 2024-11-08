
<div class="modal fade" id="roomModal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-m"> <!-- Added modal-lg for larger size -->
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="roomModalLabel">Add Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style=" padding: 30px;">
                <form id="roomForm">
                    <input type="hidden" name="room_id" id="room_id">
                    <div class="mb-3">
                        <label for="room_name" class="form-label">Room Name</label>
                        <input type="text" class="form-control" id="room_name" name="room_name" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success btn-lg px-5">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
  /* Custom Modal Styles for Room */
    #roomModal .modal-content {
        border-radius: 12px;
    }

    #roomModal .modal-header {
        background-color: #004d00; /* Dark green header */
        color: white;
        font-weight: bold;
    }

    #roomModal .modal-body input, 
    #roomModal .modal-body button {
        font-size: 1.1rem;
    }

    #roomModal .modal-body {
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

</style>
