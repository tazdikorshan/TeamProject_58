@extends('layouts.app')

@section('title', 'FAQs')

@section('content')

        <style>
:root {
--hd-orange: #F57C00;
--hd-orange-brown: #E67E22;
--hd-dark-red: #B03A2E;
--hd-black: #000000;
--hd-grey: #333333;
--hd-text-muted: #6b7280; }

.faq-section {
    max-width: 900px;
    margin: 50px auto;
    background: #ffffff;
    padding: 25px;
    border-radius: 10px;
    flex: 1;
}
.faq-title {
    text-align: center;
    margin-bottom: 25px;
    font-size: 28px;
    color: var(--hd-grey);
}
.faq-category {
    margin-top: 30px;
    margin-bottom: 10px;
    font-size: 20px;
    color: var(--hd-orange);
    border-bottom: 2px solid #eee;
    padding-bottom: 5px;
}
details[open] summary {
  margin-bottom: 16px;
}
.faq-item {
    border-bottom: 1px solid #ddd;
}
.faq-question {
    width: 100%;
    text-align: left;
    padding: 15px;
    font-size: 16px;
    background: none;
    border: none;
    cursor: pointer;
    font-weight: bold;
    list-style:none;
    color: var(--hd-black);
    position: relative;
}
.faq-question:hover {
    background: #ffffff;
}
.faq-answer {
    padding: 0 15px 15px 15px;
}
.faq-answer p {
    margin: 10px 0 20px;
    color: var(--hd-text-muted);
}
html, body {
    height: 100%;
    margin: 0;
}

body {
    min-height: 100vh;
    display: grid;
    grid-template-rows:auto;
}

footer {
    background: brown;
    color: white;
    padding: 25px 20px;
}

footer h4 {
    font-size: 12px;
    text-align: center;
    margin-bottom: 15px;
}

.footer-box {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    max-width: 1000px;
    margin: auto;
    gap: 20px;
}

.footer-col {
    flex: 1;
    min-width: 150px;
}

.footer-col h5 {
    margin-bottom: 10px;
    font-size: 15px;
}

.footer-col a {
    display: block;
    color: white;
    font-size: 15px;
    text-decoration: none;
    margin-bottom: 6px;
}

.footer-col a:hover {
    text-decoration: underline;
}
</style>
<body>
    <section class="faq-section">
    <h1 class="faq-title">Frequently Asked Questions</h1>

    <h2 class="faq-category">Orders & Payments</h2>
    <details class="faq-item">
        <summary class="faq-question">How do I place an order on HomeDome?</summary>
        <div class="faq-answer">
            <p>Browse our products, select the item you want and click “Add to Basket.” When you're ready, go to your basket and follow the secure checkout process.</p>
        </div>
    </details>

    <details class="faq-item">
        <summary class="faq-question">What payment methods do you accept?</summary>
        <div class="faq-answer">
            <p> We accept all major debit and credit cards (Visa, Mastercard), PayPal, and selected digital wallets.</p>
        </div>
    </details>

    <details class="faq-item">
        <summary class="faq-question">Can I return an item?</summary>
        <div class="faq-answer">
            <p>Yes, you can return items within 30 days of retrieval as long as they are unused.</p>
        </div>
    </details>

    <details class="faq-item">
        <summary class="faq-question">Can I modify or cancel my order after placing it?</summary>
        <div class="faq-answer">
            <p>Yes, you can modify or cancel your order within a short time after placing it. Please contact our support team as soon as possible.</p>
        </div>
        </details>

    <details class="faq-item">
        <summary class="faq-question">Can I pay at the after the delivery?</summary>
        <div class="faq-answer">
            <p>No, we only accept payments before delivery is made.</p>
        </div>
        </details>
        <details class="faq-item">
    <summary class="faq-question">Do you offer financing or installment payment options?</summary>
    <div class="faq-answer">
        <p>No, we do not offer flexible payment options on selected products.</p>
    </div>
        </details>

<h2 class="faq-category">Delivery & Shipping</h2>

<details class="faq-item">
    <summary class="faq-question">What delivery options are available?</summary>
    <div class="faq-answer">
        <p>We offer standard delivery, click & collect and reservation. </p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">How long does delivery take?</summary>
    <div class="faq-answer">
        <p>Delivery times vary depending on the product. Most items are delivered within 3–7 working days.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">Do you offer next-day or express delivery?</summary>
    <div class="faq-answer">
        <p>Unfortunately we do not offer those services.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">Can I track my order once it has been shipped?</summary>
    <div class="faq-answer">
        <p>Yes, once your order is dispatched, you can track your order in the track order page by entering the orderID given to you.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">Do you deliver to all areas in the UK?</summary>
    <div class="faq-answer">
        <p>We deliver to most areas across the UK. Some remote or offshore locations may have limited options.</p>
    </div>
</details>

<h2 class="faq-category">Returns & Refunds</h2>

<details class="faq-item">
    <summary class="faq-question">What is your return policy?</summary>
    <div class="faq-answer">
        <p>You can return most items within 30 days of delivery for a refund or exchange, provided they are unused and in original packaging.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">How do I return a faulty or damaged item?</summary>
    <div class="faq-answer">
        <p>Please contact us with photos of the issue and your order number, and we will assess the situation.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">How long do refunds take to process?</summary>
    <div class="faq-answer">
        <p>Refunds are usually processed within 5–10 working days after we receive and inspect the item.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">Do I have to pay for return shipping?</summary>
    <div class="faq-answer">
        <p>Returns due to faults or damage are free. For change-of-mind returns, a small return fee may apply.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">Can I exchange an item instead of requesting a refund?</summary>
    <div class="faq-answer">
        <p>Yes, we are happy to arrange an exchange where possible.</p>
    </div>
</details>

<h2 class="faq-category">Products & Stock</h2>

<details class="faq-item">
    <summary class="faq-question">Are your furniture items assembled or flat-packed?</summary>
    <div class="faq-answer">
        <p>Many of our items are delivered flat-packed for easy transport, but some larger pieces come pre-assembled.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">Do you provide assembly instructions with products?</summary>
    <div class="faq-answer">
        <p>Yes, all flat-pack items include clear assembly instructions and required fittings.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">What materials are your products made from?</summary>
    <div class="faq-answer">
        <p>Our furniture is made from a range of high-quality materials including solid wood, leather, MDF, metal, and durable fabrics.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">Are your products environmentally friendly or sustainable?</summary>
    <div class="faq-answer">
        <p>We aim to source materials responsibly and work with suppliers who follow sustainable practices where possible.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">What should I do if an item is out of stock?</summary>
    <div class="faq-answer">
        <p>You may have to wait for it to come back in stock, however don't worry we regularly restock our products.</p>
    </div>
</details>

<h2 class="faq-category">Product Care & Warranty</h2>

<details class="faq-item">
    <summary class="faq-question">Do your products come with a warranty or guarantee?</summary>
    <div class="faq-answer">
        <p>Yes, most products come with a 12-month manufacturer’s warranty.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">How should I care for and clean my furniture?</summary>
    <div class="faq-answer">
        <p>We recommend using a soft cloth for cleaning and avoiding harsh chemicals. Specific care instructions are provided with each item.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">What should I do if my item arrives damaged?</summary>
    <div class="faq-answer">
        <p>Please contact us within 48 hours of delivery with photos, and we will resolve the issue quickly.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">Do you offer spare parts or replacements?</summary>
    <div class="faq-answer">
        <p>Yes, we can supply spare parts for many products—just contact our support team with your order details.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">How long are your products expected to last?</summary>
    <div class="faq-answer">
        <p>With proper care, our furniture is designed to last for many years.</p>
    </div>
</details>

<h2 class="faq-category">Account & Support</h2>

<details class="faq-item">
    <summary class="faq-question">Do I need an account to place an order?</summary>
    <div class="faq-answer">
        <p>No, you can check out as a guest. However, creating an account allows you to track orders and save your details.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">How do I reset my account password?</summary>
    <div class="faq-answer">
        <p>Click “Forgot Password” on the login page and follow the instructions sent to your email.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">How can I contact HomeDome customer support?</summary>
    <div class="faq-answer">
        <p>You can contact us via email, phone, or through our online contact form.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">What are your customer service opening hours?</summary>
    <div class="faq-answer">
        <p>Our support team is available Monday to Friday, 9am – 6pm.</p>
    </div>
</details>

<details class="faq-item">
    <summary class="faq-question">Do you offer live chat or phone support?</summary>
    <div class="faq-answer">
        <p>Yes, we offer both live chat and phone support during business hours for immediate assistance.</p>
    </div>
</details>
</section>
</body>
@endsection