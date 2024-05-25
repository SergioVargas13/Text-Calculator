var timeout;

const handleInput = () => {
    clearTimeout(timeout);
    timeout = setTimeout(function() {
        document.getElementById('conversion-form').submit();
    }, 1000);
}

const cleanFields = () => {
    const words = document.getElementById('words');
    words.value = '';
}

document.addEventListener('DOMContentLoaded', function() {
    cleanFields();
    document.getElementById('words').addEventListener('keyup', handleInput);
});
