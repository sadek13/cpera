<div class="modal" id="edit-phase-modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Phase</h4>




                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form id='editPhaseForm'>
                    <label for='editPhaseName'>Phase Name:</label>
                    <input type="text" id='editPhaseName' name='editPhaseName'>
                    <br>
                    <br>
                    <label for='editPhaseColor'>Color:</label>
                    <input type="color" id='editPhaseColor' name='editPhaseColor'>



                    <br><br>
                    <input type="text" hidden id='phaseIDInput' name='phaseIDInput'>
                </form>

                <button id='edit_phase_submit' class='btn btn-large btn-danger'>Submit</button>
            </div>
        </div>
    </div>
</div>