const express = require('express');
const router = express.Router();
const Subs = require('../models/Subscription.js');

//Create subs
router.post('/subs', async (req, res) => {
    try {
        const newSub = new Subs(req.body);
        const savedSub = await newSub.save(); //Save the subs to MongoDB
        res.status(201).json(savedSub);
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
});

//Read all subs
router.get('/subs', async (req, res) => {
    try {
        const subs = await Subs.find();//Retrieve all sub documents
        res.json(subs);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

//Update a sub by ID
router.put('/subs/:id', async (req, res) => {
    try {
        const updatedSub = await Subs.findByIdAndUpdate(
            req.params.id, // The ID of the sub to update
            req.body, // The updated data
            { new: true }//Return the updated document
        );
        if (!updatedSub) {
            return res.status(404).json({ error: 'Subscription not found' });
        }
        res.json(updatedSub);
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
});

//Delete a subs by ID
router.delete('/subs/:id', async (req, res) => {
    try {
        const deletedSub = await Subs.findByIdAndDelete(req.params.id); // Remove the subs
        if (!deletedSub) {
            return res.status(404).json({ error: 'Subscription not found' });
        }
        res.json({ message: 'Subscription deleted successfully' });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});
module.exports = router;