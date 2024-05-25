var timeout;

const VOICE_LANGUAGE = 'es-ES';

const handleInput = () => {};

const cleanFields = () => {
  const words = document.getElementById("words");
  words.value = "";
};

const handleClick = () => {
  document.getElementById("convertTextToNumber").addEventListener("click", convertTextToNumber);
};

const textToSpeech = (text) => {
    const message = new SpeechSynthesisUtterance();
    message.text = text;

    console.log(window.speechSynthesis);

    window.speechSynthesis.onvoiceschanged = function() {
        loadVoices(message);
    };    
}

document.addEventListener("DOMContentLoaded", function () {
  cleanFields();
  handleClick();
});
