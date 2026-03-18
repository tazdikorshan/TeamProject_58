@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<style>
:root {
--hd-orange: #F57C00;
--hd-orange-brown: #E67E22;
--hd-dark-red: #B03A2E;
--hd-black: #000000;
--hd-grey: #333333;
--hd-text-muted: #6b7280; }

* {
  box-sizing: border-box;
}

.open-button {
  background: var(--hd-orange);
  cursor: pointer;
  border-color: brown;
  width: 65px;
  height: 65px;
  border-radius: 60px;
  position: fixed;
  bottom: 13px;
  right: 13px;
  justify-content: center;
  font-size: 11px;
}

.open-button img {
  width: 60px;
  height: 60px;
}

.chatbot {
  display: none;
  position: fixed;
  bottom: 8px;
  right: 8px;
}

.chatbot-container {
  width: 300px;
  height: 420px;
  border-radius: 13px;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.chatbot-title {
  background: var(--hd-orange);
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: bold;
  padding: 15px;
}

.chatbot-title button {
  background: none;
  border: none;
  color: white;
  font-size: 16px;
  cursor: pointer;
}

.chatbot-conversation {
  flex: 1;
  padding: 10px;
  overflow-y: auto;
  background:rgb(243, 243, 243);
}

.message {
  padding: 10px;
  margin: 5px 0;
  border-radius: 10px;
  max-width: 80%;
  word-wrap: break-word;
  overflow-wrap: break-word;
  word-break: break-word;
}

.bot {
  background:#ddd;
  color: black;
}

.user {
  background: var(--hd-orange);
  color: white;
  margin-left: auto;
}

.chatbot-send {
  display: flex;
}

.chatbot-send input {
  flex: 1;
  padding: 15px;
  border: none;
  background: #d2d2d2;
}

.chatbot-send button {
  background-color: var(--hd-orange);
  color: white;
  border: none;
  padding: 0 16px;
  cursor: pointer;
}
</style>
<body>
<button class="open-button" onclick="openForm()"><img src="{{ asset('images/Homebot.png') }}" alt="HomeBot"></button>

<div class="chatbot" id="chatbot">
  <div class="chatbot-container">

    <div class="chatbot-title">
      <p>HomeBot</p>
      <button onclick="closeForm()">✕</button>
    </div>

    <div class="chatbot-conversation" id="conversation">
      <div class="message bot">Hello, how may I help you today?</div>
    </div>

    <div class="chatbot-send">
      <input type="text" id="userInput" placeholder="Enter your message..." />
      <button onclick="sendMessage()">➤</button>
    </div>

  </div>
</div>
<script>
function openForm() {
  document.getElementById("chatbot").style.display = "block";
}

function closeForm() {
  document.getElementById("chatbot").style.display = "none";
}

function sendMessage() {
  let input = document.getElementById("userInput");
  let text = input.value.trim().toLowerCase();
  if (!text) return;

  addMessage(text, "user");
  input.value = "";

  let reply = getBotReply(text);

  setTimeout(() => {
    addMessage(reply, "bot");
  }, 400);
}
function addMessage(text, sender) {
  let chat = document.getElementById("conversation");

  let msg = document.createElement("div");
  msg.className = "message " + sender;
  msg.innerText = text;

  chat.appendChild(msg);
  chat.scrollTop = chat.scrollHeight;
}
const products = [
  { name: "oak dining table", price: 249.99, stock: 10, category: "furniture" },
  { name: "leather sofa", price: 799.99, stock: 5, category: "furniture" },
  { name: "wooden bookshelf", price: 149.99, stock: 8, category: "furniture" },
  { name: "office chair", price: 119.99, stock: 12, category: "furniture" },
  { name: "wardrobe", price: 499.99, stock: 3, category: "furniture" },
  { name: "washing machine", price: 399.99, stock: 7, category: "appliances" },
  { name: "air conditioner", price: 749.99, stock: 6, category: "appliances" },
  { name: "vacuum cleaner", price: 129.99, stock: 9, category: "appliances" },
  { name: "robot vacuum cleaner", price: 299.00, stock: 20, category: "appliances" },
  { name: "refrigerator", price: 599.99, stock: 4, category: "appliances" },
  { name: "wall clock", price: 39.99, stock: 20, category: "home decor" },
  { name: "area rug", price: 99.99, stock: 10, category: "home decor" },
  { name: "canvas painting", price: 59.99, stock: 7, category: "home decor" },
  { name: "decorative mirror", price: 89.99, stock: 6, category: "home decor" },
  { name: "indoor plant set", price: 49.99, stock: 12, category: "home decor" },
  { name: "microwave oven", price: 89.99, stock: 15, category: "kitchenware" },
  { name: "cookware set", price: 129.99, stock: 8, category: "kitchenware" },
  { name: "knife block set", price: 79.99, stock: 10, category: "kitchenware" },
  { name: "glassware set", price: 49.99, stock: 15, category: "kitchenware" },
  { name: "cutlery set", price: 69.99, stock: 9, category: "kitchenware" },
  { name: "table lamp", price: 59.99, stock: 10, category: "lighting" },
  { name: "ceiling light", price: 149.99, stock: 6, category: "lighting" },
  { name: "floor lamp", price: 89.99, stock: 5, category: "lighting" },
  { name: "string lights", price: 29.99, stock: 20, category: "lighting" },
  { name: "wall sconce", price: 69.99, stock: 7, category: "lighting" }

];
products.forEach(p => {
  p.name = p.name.toLowerCase();
  p.category = p.category.toLowerCase();
});
function findKeyword(message) {
  let keywords = message.split(" ");
  let matches = [];

  for (let product of products) {
    let productKeywords = product.name.split(" ");
    for (let keyword of keywords) {
      if (productKeywords.includes(keyword)) {
        matches.push(product);
        break;
      }
    }
  }
  return matches;
}

function getReply(message) {

  if (message.includes("hi") || message.includes("hello") || message.includes("hey")) {
    return "Hi! Welcome to HomeDome, how can I help you today?";
}
for (let product of products) {
  if (message.includes(product.name)) {

    if (message.includes("price") || message.includes("cost")) {
      return `${product.name} costs £${product.price}`;
    }
    if (message.includes("stock") || message.includes("available")) {
      return `${product.name} is in stock (${product.stock} available)`;
    }
    return `Yes, we have the ${product.name}. It costs $${product.price}.`;
  }
}
}

</script>

</body>

@endsection