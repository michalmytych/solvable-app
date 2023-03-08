<script>
    const tx = document.getElementsByTagName("textarea");

    for (let i = 0; i < tx.length; i++) {
        tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
        tx[i].addEventListener("input", e => onTextareaInput(e), false);
    }

    const onTextareaInput = (e) => {
        e.target.style.height = 0;
        e.target.style.height = (e.target.scrollHeight) + "px";
    }
</script>