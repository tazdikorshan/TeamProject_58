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
  let matches = findKeyword(message);
  if (matches.length === 1) {
    return `Are you enquiring about the ${matches[0].name}?`;
  }
  if (matches.length > 1) {
    let names = matches.map(p => p.name).join(", ");
    return `I found more than one product: ${names}. Which one of these did you mean?`;
  }
const categories = ["furniture", "appliances", "home decor", "kitchenware", "lighting"];

  for (let category1 of categories) {
    if (message.includes(category1)) {
      let items = products.filter(p => p.category === category1);
      let names = items.map(p => p.name).join(", ");
      return `Here are some ${category1} items: ${names}`;
    }
  }

    if (message.includes("order")) {
        return "What queries about orders do you have?";
    }

    if (message.includes("track")){
        return "You can track your order in the track order page in the footer.";
    }
    if (message.includes("cancel")){
        return "Please get in touch with us to cancel your order";
    }
    if (message.includes("delivery")){
        return "Delivery takes 3–7 business days.";
    }
    if (message.includes("return") || message.includes("refund")){
        return "Returns are accepted within 30 days.";
    }
  return "Sorry, I didn't understand that. I can solve any queries regarding products, price, stock or orders. ";
}
document.getElementById("userInput").addEventListener("keydown", function(e) {
  if (e.key === "Enter") {
    sendMessage();
  }
});
</script>
</body>