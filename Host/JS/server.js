// Importera nödvändiga moduler
var http = require('http');
var url = require('url');
var mysql = require('mysql');
var querystring = require('querystring');

const cors = require('cors');
const express = require('express');
const port = 3000;
const app = express();

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true })); // for parsing application/x-www-form-urlencoded


// Skapa en anslutning till MySQL-databasen
// verkligen inte säkert
const con = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'pong_realtime',
  port: 3306
});

con.connect(function(err) { // anslut till databasen
  if (err) throw err;
  console.log("Connected");
});

// Serve static files from the "public" directory, inte min kod...
app.use(express.static('public'));




// Skapa en tabell för att lagra positioner
app.post('/update-positions', (req, res) => {
  const { paddle1Y, paddle2Y, ballX, ballY } = req.body;

  const query = 'UPDATE positions SET paddle1Y = ?, paddle2Y = ?, ballX = ?, ballY = ? WHERE id = 1';
  const values = [paddle1Y, paddle2Y, ballX, ballY];

  db.query(query, values, (err, result) => {
      if (err) throw err;
      res.send('Positions updated successfully');
  });
});

// Skapa en tabell för att lagra poäng och liv
app.post('/update-game-data', (req, res) => {
  const { lives, score } = req.body;

  const query = 'UPDATE gamedata SET lives = ?, score = ? WHERE id = 1';
  const values = [lives, score];

  db.query(query, values, (err, result) => {
      if (err) throw err;
      res.send('Game data updated successfully');
  });
});
// Starta servern på port 3000
app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});