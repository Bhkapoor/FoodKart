document.querySelectorAll(".order-form-class").forEach(function (form) {
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    let currentForm = this;
    let paymentMethod = currentForm.payment_method.value;

    // COD
    if (paymentMethod === "cod") {
      let formData = new FormData(currentForm);

      fetch("orderphp.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text())
        .then((data) => {
          Swal.fire({
          title: "Congratulations!",
          text: data, 
          icon: "success"
    });
        })
        .catch((error) => {
          console.log(error);
          alert("Something went wrong");
        });

      return;
    }

    let itemPrice = parseFloat(currentForm.getAttribute("data-price")) || 0;
    let qty = parseInt(currentForm.querySelector(".quantity-field-class").value) || 1;
    let totalAmount = Math.round(itemPrice * 100 * qty);

    if (totalAmount <= 0) {
      alert("Error: Price or quantity is not correct");
      return;
    }

    var options = {
      key: "rzp_test_SqkeuTlieNzCKB",

      amount:  totalAmount,

      currency: "INR",

      order_id: razorpayOrderId,

      name: "Restaurant Order",

      description: "Food Payment",

      handler: function (response) {
        let input1 = document.createElement("input");

        input1.type = "hidden";
        input1.name = "razorpay_payment_id";
        input1.value = response.razorpay_payment_id;

        let input2 = document.createElement("input");

        input2.type = "hidden";
        input2.name = "razorpay_order_id";
        input2.value = response.razorpay_order_id || "";

        currentForm.appendChild(input1);
        currentForm.appendChild(input2);

        let formData = new FormData(currentForm);
        fetch("orderphp.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.text())
          .then((data) => {
                Swal.fire({
                title: "Congratulations!",
                text: data, 
                icon: "success"
    });
          })
          .catch((error) => {
            console.log(error);

            alert("Something went wrong");
          });
      },

      modal: {
        ondismiss: function () {
          alert("Payment window closed.");
        },
      },
    };
    var rzp = new Razorpay(options);
    rzp.open();
  });
});

console.log(razorpayOrderId);
console.log(razorpayAmount);
