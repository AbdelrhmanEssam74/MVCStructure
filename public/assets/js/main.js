// Autofocus and move to next input
document.querySelectorAll(".digit-input").forEach((input, index, inputs) => {
  input.addEventListener("input", (e) => {
    if (e.target.value.length === 1 && index < inputs.length - 1) {
      inputs[index + 1].focus();
    }
    if (e.target.value.length === 1 && index === inputs.length - 1) {
      e.target.blur(); // Blur last input
    }
  });

  input.addEventListener("keydown", (e) => {
    if (e.key === "Backspace" && !e.target.value && index > 0) {
      inputs[index - 1].focus();
    }
  });
});

// Combine the digits and submit
function handleSubmit() {
  const digits = Array.from(document.querySelectorAll(".digit-input"))
    .map((input) => input.value)
    .join("");
  if (digits.length !== 6) {
    alert("Please complete the 6-digit code.");
    return false;
  }
  document.getElementById("auth-code").value = digits; // Set hidden input value
  return true; // Allow form submission
}
