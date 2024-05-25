const convertTextToNumber = () => {
    let words = document.getElementById("words").value;

    fetch("TextCalculator.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            words: words,
        }),
    })
        .then((response) => {
            if (response.ok) {
                return response.json();
            }
            throw new Error("Network response was not ok.");
        })
        .then((data) => {
            let message = `El resultado de la conversión es: ${data}`;

            document.getElementById("resultContainer").innerHTML =
                `<div class='alert alert-success' role='alert'>
          ${message}
      </div>`;
            textToSpeech(message);
        })
        .catch((error) => {
            console.error("There was a problem with the fetch operation:", error);
        });
};
