const loadVoices = (message) => {
    const availableVoices = window.speechSynthesis.getVoices();
    const spanishVoice = availableVoices.find(voice => voice.lang === VOICE_LANGUAGE);

    if (spanishVoice) {
        message.voice = spanishVoice;
        window.speechSynthesis.speak(message);
    } else {
        console.error('Voz en español no encontrada.');
    }
};
