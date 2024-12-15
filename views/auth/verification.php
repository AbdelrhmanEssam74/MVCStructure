<div class="container">
  <div class="auth-form-container">
    <div class="auth-form-header">
      <?= (!empty(app()->session->getFlash('invalidCode'))) ? "<div class='alert alert-danger'>
      " . app()->session->getFlash('invalidCode') . "</div>"  : "" ?>
      <h2>Enter Authentication Code</h2>
    </div>
    <p class="check-mail">Check your email for the 6-digit authentication code.</p>
    <form action="/verify" method="POST" onsubmit="return handleSubmit();">
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