<style>
html, body {
    height: 100%;
    margin: 0;
}

body {
    min-height: 100vh;
    display: grid;
    grid-template-rows: auto;
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
<div class="page-content">
</div>
<footer>
    <h4>© 2025 HomeDome</h4>

    <div class="footer-box">
        <div class="footer-col">
            <h5>Company</h5>
            <a href="{{ route('About-Us') }}">About Us</a>
            <a href="{{ route('Contact-us') }}">Contact Us</a>
        </div>

        <div class="footer-col">
            <h5>Support</h5>
            <a href="{{ route('FAQs') }}">FAQs</a>
            <a href="{{ route('Privacy-policy') }}">Privacy Policy</a>
            <a href="{{ route('Terms&Conditions') }}">Terms & Conditions</a>
        </div>
        <div class="footer-col">
    <h5>Delivery & Returns</h5>
    <a href="{{ route('Delivery-information') }}">Delivery Information</a>
    <a href="{{ route('Shipping-options') }}">Shipping Options</a>
    <a href="{{ route('TrackOrder') }}">Track Your Order</a>
    <a href="{{ route('Return-policy') }}">Returns</a>
</div>
</div>
</footer>
</body>
