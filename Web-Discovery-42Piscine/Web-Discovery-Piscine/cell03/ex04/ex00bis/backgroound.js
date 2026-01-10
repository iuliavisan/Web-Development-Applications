$(document).ready(function() {
    $("#button").click(function() {
        let red = Math.floor(Math.random() * 256);
        let green = Math.floor(Math.random() * 256);
        let blue = Math.floor(Math.random() * 256);

        let randomColor = "rgb(" + red + ", " + green + ", " + blue + ")";
        $("body").css("background-color", randomColor);
    });
});