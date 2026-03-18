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
  let text = input.value.trim();
  if (text === "") return;

  addMessage(text, "user");
  input.value = "";

fetch('/chatbot', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
     'X-CSRF-TOKEN': '{{csrf-token()}}'  },
  body: JSON.stringify({
    message: text
  })
})
.then(response => response.json())
.then(data => {
  addMessage(data.reply, "bot");
});
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