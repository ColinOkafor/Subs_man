//this file creates and configures my express app
const express = require('express');
const app = express();

app.use(express.json()); // Parse incoming JSON requests

//test route
app.post('/api/test', (req, res) => {
    res.send('Test route works!');
});

//userRoutes to be connected to the client side
const userRoutes = require('./routes/userRoutes.js');
app.use('/api', userRoutes);

//subscriptionRoutes to be connected to the client side
const subscriptionRoutes = require('./routes/subscriptionRoutes.js');
app.use('/api', subscriptionRoutes);

module.exports = app;
