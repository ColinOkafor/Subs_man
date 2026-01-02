const express = require('express');
const router = express.Router();
const User = require('../models/userInfo.js');

//Create User
router.post('/users', async (req, res) => {
    try {
        const newUser = new User(req.body);
        const savedUser = await newUser.save(); //Save the user to MongoDB
        res.status(201).json(savedUser);
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
});

//Read all users
router.get('/users', async (req, res) => {
    try {
        const users = await User.find();//Retrieve all user documents
        res.json(users);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

//Update a user by ID
router.put('/users/:id', async (req, res) => {
    try {
        const updatedUser = await User.findByIdAndUpdate(
            req.params.id, // The ID od the user to update
            req.body, // The updated data
            { new: true }//Return the updated document
        );
        if (!updatedUser) {
            return res.status(404).json({ error: 'User not found' });
        }
        res.json(updatedUser);
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
});

//Delete a user by ID
router.delete('/users/:id', async (req, res) => {
    try {
        const deletedUser = await User.findByIdAndDelete(req.params.id); // Remove the user
        if (!deletedUser) {
            return res.status(404).json({ error: 'User not found' });
        }
        res.json({ message: 'User deleted successfully' });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});
module.exports = router;