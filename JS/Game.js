//Majoritet av denna kod är från ett tidigare projekt från ett annat ämne.

let canvas = document.querySelector("canvas");
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
canvas.style.width = "100%";
canvas.style.height = "100%";
let c = canvas.getContext("2d");

// ------------------------------------------------- Game Variables ------------------------------------------------- //
let lives = 50;
let score = 0;
const neededScore = 5;

let timer = document.getElementById("timer");
let gameover = false;
let isPaused = true;

// Constant positions for the paddles
const xPosPaddel = canvas.width / 6;
const xPosPaddel2 = canvas.width - canvas.width / 6;

//Generate random positions for the ball and paddles
let xPosDot = Math.floor(Math.random() * (0.8 * canvas.width - 200) + 200);
let yPosDot = Math.floor(Math.random() * (0.8 * canvas.height - 200) + 200);

let yPosPaddel = Math.floor(Math.random() * (0.8 * canvas.height - 200) + 200);
let yPosPaddel2 = Math.floor(Math.random() * (0.8 * canvas.height - 200) + 200);

// Variables for speed and direction
// Variables that store the ball's speed

let dot = {
  x: 0,
  y: 0,
  dx: 3,
  dy: 2,
  xCenter: 0,
  yCenter: 0,
  color: "red",
};

const sizeDot = 30;

// Variables that store the ball's position
let xCenterDot = (xPosDot + xPosDot + sizeDot) / 2;
let yCenterDot = (yPosDot + yPosDot + sizeDot) / 2;

let paddleSpeed = 10;
let paddleAiSpeed = 5;

const heightSizePaddel = 200;
const widthSizePaddel = 10;

// Variables for timings
let ticks = 0;
let runtime = 0;
const updateFrequency = 1; // millisecond per step

//------------------------------------------------- Paddle Game ------------------------------------------------- //
document.onkeydown = function (e) {
  const key = e.key;
  switch (key) {
    case "ArrowUp":
      if (isPaused) {
        return;
      } else {
        yPosPaddel = yPosPaddel - paddleSpeed;
        break;
      }
    case "ArrowDown":
      if (isPaused) {
        return;
      } else {
        yPosPaddel = yPosPaddel + paddleSpeed;
        break;
      }
    case " ": // Space
      isPaused = !isPaused;
      break;
  }
};

// Draws the game objects on the canvas
function update() {
  // Update the database with the current positions
  serverLogic();

  //check if game is paused
  if (isPaused) {
    menu();
    return;
  }
  clearCanvas();

  //The brainzzz of the operation
  healthBar();
  scoreTracking();
  updateDotsPosition();

  //Collision detection
  paddelCanvasCollide();
  paddelCollisionDetectionTM();
  checkBounce();
  drawRects();

  // Checks the time that has passed since the game started
  ticks++;
  runtime = (ticks / 100) * updateFrequency; // seconds
  timer.innerHTML = "Time: " + runtime.toFixed(1) + "S"; // seconds
  
}

function paddelCollisionDetectionTM() {
  //Paddel 1
  // check if the dot is within the horizontal range of the paddle
  let dotWithinPaddleX =
    xPosDot + sizeDot > xPosPaddel && xPosDot < xPosPaddel + widthSizePaddel;

  // check if the dot is within the vertical range of the paddle
  let dotWithinPaddleY =
    yPosDot + sizeDot > yPosPaddel && yPosDot < yPosPaddel + heightSizePaddel;

  // check if the dot overlaps with the paddle
  let dotOverlapsPaddle = dotWithinPaddleX && dotWithinPaddleY;

  // if the dot overlaps with the paddle, reverse its horizontal direction
  if (dotOverlapsPaddle) {
    dot.dx = -dot.dx;
  }

  //Paddel 2
  // check if the dot is within the horizontal range of the second paddle
  let dotWithinPaddle2X =
    xPosDot + sizeDot > xPosPaddel2 && xPosDot < xPosPaddel2 + widthSizePaddel;

  // check if the dot is within the vertical range of the second paddle
  let dotWithinPaddle2Y =
    yPosDot + sizeDot > yPosPaddel2 && yPosDot < yPosPaddel2 + heightSizePaddel;

  // check if the dot overlaps with the second paddle
  let dotOverlapsPaddle2 = dotWithinPaddle2X && dotWithinPaddle2Y;

  // if the dot overlaps with the second paddle, reverse its horizontal direction
  if (dotOverlapsPaddle2) {
    dot.dx = -dot.dx;
  }
}

function paddelCanvasCollide() {
  //Stop the paddle1 from going out of the canvas
  if (yPosPaddel < 0) {
    yPosPaddel = 0;
  }

  if (yPosPaddel > canvas.height - heightSizePaddel) {
    yPosPaddel = canvas.height - heightSizePaddel;
  }

  //Stop the paddle2 from going out of the canvas
  if (yPosPaddel2 < 0) {
    yPosPaddel2 = 0;
  }

  if (yPosPaddel2 > canvas.height - heightSizePaddel) {
    yPosPaddel2 = canvas.height - heightSizePaddel;
  }
}

//Check for edge bounce
function checkBounce() {
  //If the ball's position is less than 0, the ball is outside the left border.
  //If the ball's position is greater than canvas.width, the ball is outside the right border.
  //In both cases, the ball's direction is reversed.
  if (xPosDot < 0 || xPosDot > canvas.width - sizeDot) {
    dot.dx = -dot.dx;
  }

  if (yPosDot < 0 || yPosDot > canvas.height - sizeDot) {
    dot.dy = -dot.dy;
  }

  if (xPosDot < 0) {
    lives--;
    game_ignition();
  }

  if (xPosDot > canvas.width - sizeDot) {
    score++;
    game_ignition();
  }
}

function clearCanvas() {
  c.fillStyle = "rgba(0, 0, 0, 0.2)";
  c.fillRect(0, 0, canvas.width, canvas.height);
}

function updateDotsPosition() {
  xPosDot += dot.dx;
  yPosDot += dot.dy;

  xCenterDot = (xPosDot + xPosDot + sizeDot) / 2;
  yCenterDot = (yPosDot + yPosDot + sizeDot) / 2;
}

function drawRects() {
  // The red dot (rectangle) is drawn in its new position
  c.fillStyle = dot.color;
  c.fillRect(xPosDot, yPosDot, sizeDot, sizeDot);

  // the white paddel (rectangle) is drawn in its new position
  c.fillStyle = "white";
  c.fillRect(xPosPaddel, yPosPaddel, widthSizePaddel, heightSizePaddel);

  // the white paddel (AI) (rectangle) is drawn in its new position
  c.fillStyle = "white";
  c.fillRect(xPosPaddel2, yPosPaddel2, widthSizePaddel, heightSizePaddel);
}

function PaddelAI() {
  if (yPosPaddel2 < yCenterDot) {
    yPosPaddel2 = yPosPaddel2 + paddleAiSpeed;
  }

  if (yPosPaddel2 > yCenterDot) {
    yPosPaddel2 = yPosPaddel2 - paddleAiSpeed;
  }
}

//Generate random positions for the ball and paddles
function game_ignition() {
  xPosDot = Math.floor(Math.random() * (0.8 * canvas.width - 200) + 200);
  yPosDot = Math.floor(Math.random() * (0.8 * canvas.height - 200) + 200);

  yPosPaddel = Math.floor(Math.random() * (0.8 * canvas.height - 200) + 200);
  yPosPaddel2 = Math.floor(Math.random() * (0.8 * canvas.height - 200) + 200);
}

// ------------------------------------------------- init ------------------------------------------------- //

function menu() {
  clearCanvas();
  c.fillStyle = "black";
  c.fillRect(0, 0, canvas.width, canvas.height);
  c.font = "100px Arial";
  c.fillStyle = "white";
  c.textAlign = "center";
  c.fillText(
    "Welcome to Nuke-Nation Pong",
    canvas.width / 2,
    canvas.height / 4
  );
  c.font = "40px Arial";
  c.fillText(
    "Remember to press space to play / pause the game",   
        canvas.width / 2,
        canvas.height / 2
      );
}

//------------------------------------------------- Game Loops -------------------------------------------------//

function healthBar() {
  c.fillStyle = "red";
  c.fillRect(canvas.width / 4, 0, canvas.width / 2, 10);

  //Draw the green health bar, the width is depended on the current health
  c.fillStyle = "green";
  c.fillRect(canvas.width / 4,0,(canvas.width / 2) * (lives / 50),10);
}

function scoreTracking() {
  c.fillStyle = "white";
  c.font = "30px Arial";

  c.fillText("Score: " + score, 100, 125);
  c.fillText("Lives: " + lives, 100, 100);

  c.fillText("Needed score: " + neededScore, canvas.width - 200, 100);
  if (lives == 0) {
    clearInterval(GameUpdater);
    clearInterval(PaddleAIUpdater);
    alert("AI wins!");
    document.location.reload();
  }
  if (score == neededScore) {
    clearInterval(GameUpdater);
    clearInterval(PaddleAIUpdater);
    alert("Player wins!");
    document.location.reload();
  }
}




// ------------------------------------------------- Game Loops ------------------------------------------------- //

let GameUpdater = setInterval(update, updateFrequency);
let PaddleAIUpdater = setInterval(PaddelAI, 10); //AI limiter so that it doesn't take over the world
game_ignition();
