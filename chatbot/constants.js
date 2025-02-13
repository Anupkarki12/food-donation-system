// Options the user could type in
let date=new Date(); 
var currentdate=new Date().toLocaleDateString();
var time=new Date().toLocaleTimeString();
const prompts = [
  ["hi", "hey", "hello", "good morning", "good afternoon"],
  ["how are you", "how is life", "how are things"],
  ["what are you doing", "what is going on", "what is up"],
  ["how old are you"],
  ["who are you", "are you human", "are you bot", "are you human or bot"],
  ["who created you", "who made you"],
  [
    "your name please",
    "your name",
    "may i know your name",
    "what is your name",
    "what call yourself"
  ],
  ["i love you"],
  ["happy", "good", "fun", "wonderful", "fantastic", "cool"],
  ["bad", "bored", "tired"],
  ["help me", "tell me story", "tell me joke"],
  ["ah", "yes", "ok", "okay", "nice"],
  ["bye", "good bye", "goodbye", "see you later"],
  ["what should i eat today"],
  ["bro"],
  ["what", "why", "how", "where", "when"],
  ["no", "not sure", "maybe", "no thanks"],
  [""],
  ["haha", "ha", "lol", "hehe", "funny", "joke"],
  ["food donate", "project"],
  ["date"],
  ["time"],
  ["what can i donate", "donate"],
  ["trust in madurai", "ngos in madurai"],
  ["tell joke"],
  ["how can I package my cooked or raw food donations", "cooked food donation", "raw food donate"],
  ["how my donation is used"],
  ["can i donate cooked food"],
  ["what are the guidelines for donating"],
  ["what is food waste management", "explain food waste management"],
  ["how to reduce food waste", "tips to reduce food waste"],
  ["can i track my donation", "track donation status"]
];

const replies = [
  ["Hello!", "Hi!", "Hey!", "Hi there!", "Howdy"],
  ["I'm doing well, how about you?", "Pretty good, how are you?", "Fantastic, how are you?"],
  ["I'm here to assist with food waste management queries.", "Helping reduce food waste!", "Thinking about how to help people today!"],
  ["I am ageless, but always learning."],
  ["I am a chatbot designed to help manage food waste effectively.", "I am your assistant for food waste management."],
  ["I was created by Kishor and Uppili."],
  ["I am Chitti, your friendly food waste management assistant."],
  ["I love you too!", "You're sweet!"],
  ["That's great to hear!", "Awesome!", "Keep smiling!"],
  ["I'm sorry to hear that. How can I help?", "Let's find a way to cheer you up!"],
  ["Sure! What do you need help with?", "Once upon a time..."],
  ["Alright!", "Got it!", "Nice!"],
  ["Goodbye! Take care!", "See you later!", "Bye!"],
  ["How about trying some healthy options like a salad or smoothie?"],
  ["Bro!"],
  ["Great question! What do you want to know?"],
  ["That's okay, take your time.", "I understand, let me know when you're ready."],
  ["Please say something so I can help."],
  ["Haha! That's funny!", "Good one!"],
  ["This project aims to collect excess or leftover food from donors like hotels, restaurants, and marriage halls to distribute it to needy people."],
  [new Date().toLocaleDateString()],
  [new Date().toLocaleTimeString()],
  ["You can donate raw, cooked, and packaged foods."],
  ["Madurai Old Age Charitable Trust, 208, East Veli Street, Near Keshavan Hospital."],
  ["Why did the tomato turn red? Because it saw the salad dressing!"],
  ["Package cooked or raw food donations in airtight containers. Use labels with food type, date, and instructions for better organization."],
  ["Your donation supports programs that distribute food to the needy. Learn more on our website or contact us for details."],
  ["Yes, you can donate cooked food if it is prepared in a licensed kitchen and properly packaged."],
  ["Unopened, unexpired raw items can be donated. Ensure they are in good condition."],
  ["Food waste management involves reducing, reusing, and redistributing surplus food to minimize waste and support those in need."],
  ["Reduce food waste by planning meals, storing food properly, donating excess food, and composting organic waste."],
  ["Yes, you can track your donation through our system. Contact us for more details."]
];

const alternative = [
  "I'm sorry, I couldn't understand that. Could you rephrase your question?",
  "I'm still learning! Can you clarify your query?",
  "That's an interesting question. Let me think about it!"
];

function getResponse(input) {
  input = input.toLowerCase().trim();

  for (let i = 0; i < prompts.length; i++) {
    for (let prompt of prompts[i]) {
      if (input.includes(prompt)) {
        const responses = replies[i];
        return responses[Math.floor(Math.random() * responses.length)];
      }
    }
  }
  return alternative[Math.floor(Math.random() * alternative.length)];
}

// Example usage
const userInput = "can you tell me about food donate";
console.log(getResponse(userInput));
