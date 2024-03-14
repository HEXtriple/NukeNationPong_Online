
const mysql = require('mysql');
const jwt = require('jsonwebtoken');
const express = require('express');
const app = express();
const crypto = require('crypto');

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

//POST
app.post('/user', (req, res) => {
  const { name, userName, passwd} = req.body;
  con.query('INSERT INTO users (name, userName, passwd) VALUES (?, ?, ?, ?)', [name, userName, passwd], (err, result) => {
    if (err) throw err;
    const insertedId = result.insertId;
    con.query('SELECT * FROM users WHERE id = ?', [insertedId], (err, rows) => {
      if (err) throw err;
      res.status(201).send(rows[0]);
    });
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

//DELETE
app.delete('/user/:id', (req, res) => {
  con.query('DELETE FROM users WHERE id = ?', [req.params.id], (err, result) => {
    if (err) throw err;
    res.send('User deleted');
  });
});



//Login API 
function hash(data) {
  const hash = crypto.createHash('sha256');
  hash.update(data);
  return hash.digest('hex')
}


app.post('/login', (req, res) => {
  const {userName, passwd} = req.body;
  con.query('SELECT * from users WHERE userName = ? AND passwd = ?', [userName, hash(passwd)], (err, result) => {
    console.log(result);
    if (err) {
      throw err;
    } else if (result.length > 0) {
      const token = jwt.sign({ userName: result[0].userName }, 'secret', { expiresIn: '1h' });
      res.send({ token });
    } else {
      res.status(401).send('Invalid username or password');
    }
  });
});

app.get('/loginSession/:id', (req, res) => {
  const authHeader = req.headers.authorization;
  if (!authHeader) {
    res.status(401).send('Unauthorized');
    return;
  }

  const token = authHeader.split(' ')[1]; // Extract the token from the Bearer scheme

  jwt.verify(token, 'secret', (err, decoded) => {
    if (err) {
      res.status(401).send('Invalid token');
      return;
    }

    con.query('SELECT * FROM users WHERE id = ?', [req.params.id], (err, rows) => {
      if (err) throw err;
      res.send(rows[0]);
    });
  });
});


app.listen(5000, () => console.log('Server started. Listening on localhost:5000')); 


