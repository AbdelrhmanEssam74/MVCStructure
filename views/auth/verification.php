<div class="container">
  <div class="auth-form-container">
    <div class="auth-form-header">
      <?= (!empty(app()->session->getFlash('invalidCode'))) ? "<div class='alert alert-danger'>
      " . app()->session->getFlash('invalidCode') . "</div>"  : "" ?>
      <?= (!empty(app()->session->getFlash('expiredCode'))) ? "<div class='alert alert-danger'>
      " . app()->session->getFlash('expiredCode') .
        " <a data-bs-toggle='modal' data-bs-target='#exampleModal' data-whatever='@mdo' href='#'>Resend Code</a> </div>"  : "" ?>
      <?= (!empty(app()->session->getFlash('invalidEmail'))) ? "<div class='alert alert-danger'>
      " . app()->session->getFlash('invalidEmail') .
        " <a data-bs-toggle='modal' data-bs-target='#exampleModal' data-whatever='@mdo' href='#'>Try Again</a> </div>"  : "" ?>
      <?= (!empty(app()->session->getFlash('validEmail'))) ? "<div class='alert alert-success'>
      " . app()->session->getFlash('validEmail') .
        " </div>"  : "" ?>
      <h2>Enter Authentication Code</h2>
    </div>
    <p class="check-mail">Check your email for the 6-digit authentication code.</p>
    <form action="/check-auth-code" method="POST" onsubmit="return handleSubmit();">
      <div id="digit-container" class="d-flex justify-content-center mb-4">
        <input type="text" class="digit-input" id="digit-1" maxlength="1" required>
        <input type="text" class="digit-input" id="digit-2" maxlength="1" required>
        <input type="text" class="digit-input" id="digit-3" maxlength="1" required>
        <input type="text" class="digit-input" id="digit-4" maxlength="1" required>
        <input type="text" class="digit-input" id="digit-5" maxlength="1" required>
        <input type="text" class="digit-input" id="digit-6" maxlength="1" required>
      </div>
      <input type="hidden" name="auth_code" id="auth-code">
      <button type="submit" id="btn-custom" class="btn ">Authenticate</button>
    </form>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelOne" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelOne">Enter Your Email Address</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="/resend-auth-code">
          <div class="form-group mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              placeholder="Enter your email"
              value="<?= app()->session->hasFlash('oldEmail') ? app()->session->getFlash('oldEmail') : ''; ?>">
            <?php if (app()->session->hasFlash('email')): ?>
              <div class="invalid-feedback">
                <?= app()->session->getFlash('email')[0]; ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>