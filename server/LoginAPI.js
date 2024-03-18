
const mysql = require('mysql');
const express = require('express');
const app = express();

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

var con = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "forskalleforumnet",  
  port: 3306
});

con.connect(function(err) { // anslut till databasen
  if (err) throw err;
  console.log("Connected");
});

//GET
app.get('/user', (req, res) => {
  con.query('SELECT userName FROM users', (err, rows) => {
    if(err) throw err;
    res.send(rows);
  });
});

app.get('/users/:id', (req, res) => {
  con.query('SELECT * FROM users WHERE id = ?', [req.params.id], (err, rows) => {
    if(err) throw err;
    res.send(rows[0]);
  });
});


//PUT
app.put('/user/:id', (req, res) => {
  const { name, userName, passwd } = req.body;
  con.query('UPDATE users SET name, userName = ?, passwd = ? WHERE id = ?', [name, userName, passwd, req.params.id], (err, result) => {
    if (err) throw err;
    con.query('SELECT * FROM users WHERE id = ?', [req.params.id], (err, rows) => {
      if (err) throw err;
      res.send(rows[0]);
    });
  });
});