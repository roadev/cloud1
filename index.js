const units = {
  distance: ["km", "miles"],
  temperature: ["celsius", "fahrenheit"],
  mass: ["kg", "pounds"],
  volume: ["liters", "gallons"],
};

function updateUnits(type) {
  const from = document.getElementById("from");
  const to = document.getElementById("to");

  from.innerHTML = "";
  to.innerHTML = "";

  if (units[type]) {
    units[type].forEach((unit) => {
      from.options.add(new Option(unit, unit));
      to.options.add(new Option(unit, unit));
    });
  }
}

// Add an event listener to the form submission
// Add an event listener to the form submission
document
  .getElementById("conversionForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    // Fetch the form data
    const type = document.getElementById("type").value;
    const value = document.getElementById("value").value;
    const from = document.getElementById("from").value;
    const to = document.getElementById("to").value;

    // Create a new FormData object
    const formData = new FormData();
    formData.append("type", type);
    formData.append("value", value);
    formData.append("from", from);
    formData.append("to", to);

    // Fetch the conversion result
    fetch("unitConversion.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((result) => {
        // Check for errors
        if (result.startsWith("<p>Invalid")) {
          // If there's an error, color the result paragraph in red
          document.getElementById("result").style.color = "red";
        } else {
          // If there's no error, color the result paragraph in black
          document.getElementById("result").style.color = "black";
        }
        // Update the result paragraph
        document.getElementById("result").textContent = result;
      })
      .catch(console.error);
  });
