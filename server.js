const dotenv = require('dotenv');
const app = require('./src/app');
dotenv.config();
const mongoose = require('mongoose');

const db = process.env.MONGO_URI;
const Port = process.env.PORT;
mongoose
    .connect(db)
    .then(() => console.log("MongoDB connected"))
    .catch(err => console.error("MongoDB connection error:", err));

app.listen(Port, () => console.log(`Server running on port ${Port}`)); 