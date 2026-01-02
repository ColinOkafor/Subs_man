const mongoose = require('mongoose');
const { Schema, model } = mongoose;

const Users = new Schema({
    name: {
        type: String,
        required: true
    },
    email: {
        type: String,   //prevents duplicate accounts and normalizes emails.
        required: true,
        unique: true,
        lowercase: true,
        trim: true
    },
    password: {
        type: String,
        required: true
    }
},
    { timestamps: true }
);

const userInfo = model('userInfo', Users);
module.exports = userInfo;
