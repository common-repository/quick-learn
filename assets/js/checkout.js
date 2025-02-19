// A reference to Stripe.js initialized with a fake API key.
const stripe = Stripe(PAYMENTVERIABLE.public_key);
const items = [{ id: "xl-tshirt" }];
let elements;
document
  .querySelector("#payment-form")
  .addEventListener("submit", handleSubmit);
// Fetches a payment intent and captures the client secret

var stripepaybtn = document.getElementsByClassName("stripepaybtn")[0];


stripepaybtn.addEventListener("click", initialize);


async function initialize() {
  const clientSecret = await fetch(PAYMENTVERIABLE.path, {
    method: "POST",

    headers: { "Content-Type": "application/json" },

    body: JSON.stringify({ items }),

  }).then((r) => r.json());

  elements = stripe.elements(clientSecret);
  const paymentElement = elements.create("payment");
  paymentElement.mount("#payment-element");

}





async function handleSubmit(e) {
  e.preventDefault();
  //setLoading(true);
  const { error } = await stripe.confirmPayment({
    elements,
    confirmParams: {
      return_url: PAYMENTVERIABLE.return_url1,
    },
  });

  if (error.type === "card_error" || error.type === "validation_error") {
    showMessage(error.message);
  } else {
    showMessage("An unexpected error occured.");
  }
  //setLoading(false);
}
// Fetches the payment intent status after payment submission
async function checkStatus() {

  const clientSecret = new URLSearchParams(window.location.search).get(
    "payment_intent_client_secret"

  );
  if (!clientSecret) {
    return;

  }
  const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);
  switch (paymentIntent.status) {
    case "succeeded":
      showMessage("Payment succeeded!");
      break;
    case "processing":
      showMessage("Your payment is processing.");
      break;
    case "requires_payment_method":
      showMessage("Your payment was not successful, please try again.");
      break;
    default:
      showMessage("Something went wrong.");
      break;

  }

}
// ------- UI helpers -------

function showMessage(messageText) {
  const messageContainer = document.querySelector("#payment-message");
  messageContainer.classList.remove("hidden");
  messageContainer.textContent = messageText;
  setTimeout(function () {
    messageContainer.classList.add("hidden");
    messageText.textContent = "";

  }, 4000);
}
// Show a spinner on payment submission
function setLoading(isLoading) {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("#submit").disabled = true;
    document.querySelector("#spinner").classList.remove("hidden");
    document.querySelector("#button-text").classList.add("hidden");
  } else {
    document.querySelector("#submit").disabled = false;
    document.querySelector("#spinner").classList.add("hidden");
    document.querySelector("#button-text").classList.remove("hidden");
  }

}