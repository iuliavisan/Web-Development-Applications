let button = document.getElementById("button");

function changeBackgroundColor(){
    let red = Math.floor(Math.random() * 256);
    let green = Math.floor(Math.random() * 256);
    let blue = Math.floor(Math.random() * 256);
    // generates ranom numbers

    let randomColor = "rgb(" + red + ", " + green + ", " + blue + ")";
    // forms a color
    document.body.style.backgroundColor = randomColor;
    // sets the background color
}

button.addEventListener("click", changeBackgroundColor);