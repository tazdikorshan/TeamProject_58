@extends('layouts.app')

@section('title', 'Terms & Conditions')

@section('content')

<style>
:root {
  --hd-orange: #F57C00;
  --hd-orange-brown: #E67E22;
  --hd-dark-red: #B03A2E;
  --hd-black: #000000;
}
.Terms-box {
      max-width: 1000px;
      margin: 20px auto;
      padding: 40px 30px;
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.546);
      text-align: left;
    }
    
    h1 {
      font-size: 40px;
      margin-bottom: 20px;
      color: var(--hd-orange);
      font-weight: 800;
    }

    h2 {
      margin-top: 30px;
      font-size: 20px;
      color: var(--hd-dark-red);
      font-weight: 700;
    }

    p {
      margin: 3px;
      color: black;
      font-size: 15px;
    }

    ul {
      margin: 20px;
    }
</style>
<body>
    <div class="Terms-box">
    <h1>Terms & Conditions</h1>
    <p>
      Welcome to HomeDome. By accessing or using our website, you agree to be bound by the following terms and conditions. Please read them carefully before using our services.
    </p>

    <h2>1. Use of Our Website</h2>
    <p>
      You agree to use our website only for lawful purposes. You must not misuse our website by introducing viruses, attempting unauthorised access, or engaging in harmful activities.
    </p>

    <h2>2. Products and Availability</h2>
    <p>
      All products are subject to availability. We reserve the right to limit quantities, discontinue products, or change specifications without notice.
    </p>

    <h2>3. Pricing and Payment</h2>
    <p>
      Prices are displayed in GBP and include VAT where applicable. We reserve the right to change prices at any time. Payment must be completed before your order is processed.
    </p>

    <h2>4. Orders</h2>
    <p>
      Once an order is placed, you will receive a confirmation email. This does not guarantee acceptance of your order. We reserve the right to cancel or refuse any order.
    </p>

    <h2>5. Delivery</h2>
    <p>
      Delivery times are estimates and may vary. We are not liable for delays caused by external factors. Risk passes to you upon delivery.
    </p>

    <h2>6. Returns and Refunds</h2>
    <p>
      You may return items within 14 days of receipt, subject to our returns policy. Items must be unused and in original packaging.
    </p>

    <h2>7. Account Responsibility</h2>
    <p>
      You are responsible for maintaining the confidentiality of your account details and for all activities under your account.
    </p>

    <h2>8. Limitation of Liability</h2>
    <p>
      To the fullest extent permitted by law, HomeDome shall not be liable for any indirect, incidental, or consequential damages arising from the use of our website or products.
    </p>

    <h2>9. Intellectual Property</h2>
    <p>
      All content on this website, including text, images, and logos, is the property of HomeDome and may not be used without permission.
    </p>

    <h2>10. Changes to These Terms</h2>
    <p>
      We may update these terms from time to time. Continued use of the website constitutes acceptance of any changes.
    </p>

    <h2>11. Contact Us</h2>
    <p>
      If you have any questions about these Terms & Conditions, please contact us at:
    </p>
    <p>Email: homedomequeries@gmail.com</p>

  </div>

</body>

@endsection