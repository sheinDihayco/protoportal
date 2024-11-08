
<!-- JavaScript to Clear the Search Input Field -->
<script>
function clearInputField() {
    document.querySelector('input[name="search_user"]').value = '';
    // Hide the table by reloading the page without the search_user parameter
    window.location.href = window.location.pathname;
}
</script>

