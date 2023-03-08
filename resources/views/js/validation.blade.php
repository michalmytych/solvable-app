<script>
    const validateRequiredInputsLive = (ids, onValidationError = null, onValidationSuccess = null) => {
        const inputs = ids.map(_id => document.getElementById(_id));

        const validator = () => {
            let isSuccessful = inputs.every(i => i.value);

            if (isSuccessful && onValidationSuccess) {
                onValidationSuccess();
            }

            if (!isSuccessful && onValidationError) {
                onValidationError();
            }
        }

        validator();
        inputs.forEach(i => i.addEventListener('input', validator));
    }
</script>