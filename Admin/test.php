<input
    type="text"
    id="username"
    placeholder="Username (no spaces)"
>
<small id="username-error" style="color:red;"></small>

<script>
const input  = document.getElementById('username');
const error  = document.getElementById('username-error');

input.addEventListener('input', function () {
    if (this.value.includes(' ')) {
        error.textContent = 'No space allowed';
        // optional: remove the space automatically
        this.value = this.value.replace(/\s+/g, '');
    } else {
        error.textContent = '';
    }
});
</script>