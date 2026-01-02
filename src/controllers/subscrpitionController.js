const Subscription = require("../models/Subscription.js");
//Create a new sub and insert into the database
const Sub = await Subscription.create({
    user: 'Jon Doe',
    title: 'OpenAi premium',
    description: "for school and projects",
    dueDate: "2026-12-28",
    isDone: false,
    price: "19.99",
    billingCycle: "annually",
    status: "saved"
});
console.log('Created Sub', OpenAI);

//Updates the sub
Sub.title = "ChatGPT plus";
await article.save();
console.log("Updated sub", Sub);