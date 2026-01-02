const mongoose = require('mongoose');
const { Schema, model } = mongoose;

const subSchema = new Schema({
    user: {
        type: Schema.Types.ObjectId,
        ref: "Users",
        required: true
    },
    title: { type: String, required: true },
    description: String,
    dueDate: Date,
    isDone: { type: Boolean, default: false },
    price: { type: Number, min: 0 },
    billingCycle: { type: String, enum: ["monthly", "yearly"] },
    status: {
        type: String,
        enum: ["saved", "due"],
        default: "saved"
    }
},
    { timestamps: true }
);

const Subscription = model('Subscription', subSchema);
module.exports = Subscription;
