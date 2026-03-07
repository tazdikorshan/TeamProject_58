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
  background-color: var(--hd-orange);
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.9;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

.chatbot {
  display: none;
  position: fixed;
  bottom: 0;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}

.chatbot-container {
  max-width: 300px;
  background-color: white;
  display: flex;
  flex-direction: column;
  height: 400px;
}

.chatbot-conversation {
  flex: 1;
  padding: 10px;
  overflow-y: auto;
  background: #f1f1f1;
}

.message {
  padding: 10px;
  margin: 5px 0;
  border-radius: 10px;
  max-width: 80%;
}

.bot {
  background: #ddd;
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
  background: #f1f1f1;
}

.chatbot-send button {
  background-color: var(--hd-orange);
  color: white;
  border: none;
  padding: 0 16px;
  cursor: pointer;
  opacity: 0.9;
}

.cancel {
  background-color: red;
}

.chatbot-send button:hover,
.open-button:hover {
  opacity: 1;
}
</style>
<body>
<button class="open-button" onclick="openForm()">HomeBot</button>

<div class="chatbot" id="chatbot">
  <div class="chatbot-container">

    <div class="chatbot-title">
      <p>HomeBot<p>
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
  let text = input.value.trim();
  if (text === "") return;

  addMessage(text, "user");
  input.value = "";

  setTimeout(() => {
    botResponse(text.toLowerCase());
  }, 600);
}
function addMessage(text, sender) {
  let chat = document.getElementById("conversation");

  let msg = document.createElement("div");
  msg.className = "message " + sender;
  msg.innerText = text;

  chat.appendChild(msg);
  chat.scrollTop = chat.scrollHeight;
}
document.getElementById("userInput").addEventListener("keydown", function(enter) {
  if (enter.key === "Enter") {
    sendMessage();
  }
});
</script>
</body>

@endsection