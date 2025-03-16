let input = document.getElementById('input-upload-preview');
let imageSource = document.getElementById('image-display-preview');

input.addEventListener('change', function(e) {
    if (e.target.files.length) {
        let source = URL.createObjectURL(e.target.files[0]); // create a temporary URL
        imageSource.src = source;
    }
});
document.addEventListener("DOMContentLoaded", function() {
    let input2 = document.getElementById('input-upload-preview');
    if (input2.files.length > 0) {
        let source = URL.createObjectURL(input2.files[0]); // create a temporary URL
        imageSource.src = source;
    }
})