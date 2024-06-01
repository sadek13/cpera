<!DOCTYPE html>
<html lang="en">

<head>
  <?php require('../common/head.php'); ?>
  <style>
    body {
      background-color: white;
    }
  </style>
</head>

<body>
  <!-- modal -->
  <!-- modal-end -->
  <section class="vh-100">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 text-black">



          <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

            <form style="width: 23rem;" action='../actions/users/login.php' type='POST' id='loginForm'>

              <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>

              <div class="form-outline mb-4">
                <input type="text" id="form2Example18" class="form-control form-control-lg" name='username' />
                <label class="form-label" for="form2Example18">Username</label>
              </div>

              <div class="form-outline mb-4">
                <input type="password" id="form2Example28" class="form-control form-control-lg" name='password' />
                <label class="form-label" for="form2Example28">Password</label>
              </div>

              <div class="pt-1 mb-4">
                <button class="btn btn-info btn-lg btn-block" type="submit">Login</button>
              </div>


            </form>

          </div>

        </div>

      </div>
    </div>
  </section>


  <!-- JavaScript Libraries -->

  <?php require('../common/script.php') ?>
  <!-- Template Javascript -->

</body>

</html>

<script>
  $(document).ready(function() {




    $('#loginForm').on('submit', function(e) {
      e.preventDefault();

      // Serialize the form data
      let formData = $(this).serialize();

      // Specify the URL for the AJAX request
      let url = $(this).attr('action');

      // Make the AJAX request
      $.ajax({
        type: 'POST', // or 'GET' depending on your form submission method
        url: url,
        data: formData,
        success: function(response) {
          // Handle the success response here
          if (response.status == 'ok') {


            window.location.href = '../pages/today.php'
          } else {

            Swal.fire({
              title: 'OOPS!',
              text: response.message,
              icon: 'fail',
              confirmButtonText: 'Try argain'
            })
          }

        },
        error: function(error) {
          // Handle the error response here
          console.error(error);
        }
      });
    });

    $('input[type="text"],textarea,input[type="password"]').on('input', function() {
      var trimmedValue = $(this).val().trim();
      if (trimmedValue == "") {
        $(this).val(trimmedValue);
      }
    });
  })
</script>