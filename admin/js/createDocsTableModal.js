function createDocsTableModal(assignees,docs){
    let html = `
    <div class="modal" id="docsModal">
      <div class="modal-dialog">
        <div class="modal-content">
    
          <!-- Modal Header -->
          <div class="modal-header">
            <input type="text" id="employee-searcher" placeholder="Search...">
            <i class="fas fa-search search-icon" id="searchIcon"></i>
          </div>
    
          <!-- Modal body -->
          <div class="modal-body">
            <form method="post" action="../actions/employees/add_employee_to_div.php" id='addEmployeeToDivForm'>
              <table class="table">`;
    
    assignees.forEach(assignee => {

        let assignee_id = assignee.assignee_id;
        let docsHTML = '';
        docs.forEach(doc => {
            if (doc.posted_by == assignee_id) {
                let image_path = doc.image_path;
                // Correct usage of template literals for dynamic image paths
                docsHTML += `<img style='display:block' src='../images/${image_path}.png'>`;
            }
        });
        // Correct way to append rows and cells to the table HTML
        html += `<tr>
                   <td><img src='../images/docs/${assignee.pp}'></td>
                   <td>${assignee.employee_fn}</td>
                   <td>${docsHTML}</td>
                 </tr>`;
    });
    
    // Continuing the HTML string after the forEach loop
    html += `</table>
              <button type="submit" class="btn btn-danger modalAddButton">ADD</button>
            </form> 
          </div>
    
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          </div>
    
        </div>
      </div>
    </div>`;
    
    // Now, `html` is ready to be inserted into the DOM or used as needed.
   
    var paragraph = $('<div></div>').text(html);
    $("body").append(paragraph);

    
    }