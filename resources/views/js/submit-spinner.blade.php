<script>
    const submitButton = document.getElementById('submitButton');
    const spinner = document.getElementById('spinner');

    const handleButtonClick = () => {
        submitButtonWrapper.style.display = 'none';
        spinner.style.display = '';
    }

    submitButton.addEventListener('click', () => handleButtonClick());
</script>