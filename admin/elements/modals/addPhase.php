<div class="modal" id="add-phase-modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Phase</h4>




                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form id='addPhaseForm'>
                    <label for='addPhaseName'>Phase Name:</label>
                    <input type="text" id='addPhaseName' name='addPhaseName'>
                    <br>
                    <br>
                    <label for='addPhaseColor'>Color:</label>
                    <input type="color" id='addPhaseColor' name='addPhaseColor'>

                    <input type='text' id='addPhaseProjectID' name='addPhaseProjectID' hidden>
                </form>

                <button id='add_phase_submit' class='btn btn-large btn-danger'>Submit</button>
            </div>
        </div>
    </div>
</div>