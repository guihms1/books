const valor = document.getElementById("Valor");
const anoPublicacao = document.getElementById("AnoPublicacao");

valor.addEventListener("input", function (e) {
    let value = e.target.value;

    // Remove all non-numeric characters
    value = value.replace(/[^\d]/g, "");

    // If there's input, format it as currency
    if (value.length > 0) {
        value = (parseInt(value, 10) / 100).toFixed(2);
    }

    e.target.value = value;
});

anoPublicacao.addEventListener("input", function (e) {
    let value = e.target.value;

    // Remove any non-numeric characters
    value = value.replace(/[^\d]/g, "");

    // Limit to 4 digits
    if (value.length > 4) {
        value = value.slice(0, 4);
    }

    // Update the input value
    e.target.value = value;
});
