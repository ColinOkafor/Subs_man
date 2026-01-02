const userInfo = require("../models/userInfo");
const User = await userInfo.create({
    name: 'Jon Doe',
    email: 'joedoe225@yahoo.com',
    password: "htU56yjhjk"
});
console.log('Created user', User);
