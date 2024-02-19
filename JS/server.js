// Importera nödvändiga moduler
var http = require('http');
var url = require('url');
var mysql = require('mysql');
var querystring = require('querystring');

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