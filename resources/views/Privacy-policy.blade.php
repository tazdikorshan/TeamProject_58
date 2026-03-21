@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')

<style>
:root {
  --hd-orange: #F57C00;
  --hd-orange-brown: #E67E22;
  --hd-dark-red: #B03A2E;
  --hd-black: #000000;
}
.Privacy-box {
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
  <div class="Privacy-box">
    <h1>Privacy Policy</h1>
    <p>
      At HomeDome, we respect your privacy and are committed to protecting your personal data. This policy explains how we collect, use, and safeguard your information when you use our website.
    </p>

    <h2>1. Information We Collect</h2>
    <p>We may collect the following types of personal information:</p>
    <ul>
      <li>Name and contact details (email address, phone number)</li>
      <li>Delivery and billing address</li>
      <li>Payment information</li>
      <li>Account login details</li>
      <li>Browsing behaviour and website usage data</li>
    </ul>

    <h2>2. How We Use Your Information</h2>
    <p>Your information is used to:</p>
    <ul>
      <li>Process and deliver your orders</li>
      <li>Manage your account</li>
      <li>Provide customer support</li>
      <li>Improve our website and services</li>
      <li>Send updates, offers, and marketing (if you opt in)</li>
    </ul>

    <h2>3. Sharing Your Information</h2>
    <p>
      We do not sell your personal data. We may share your information with trusted third parties such as delivery partners, payment providers, and service providers necessary to operate our business.
    </p>

    <h2>4. Cookies</h2>
    <p>
      We use cookies to enhance your browsing experience, analyse traffic, and personalise content. You can control cookie settings through your browser.
    </p>

    <h2>5. Data Security</h2>
    <p>
      We take appropriate measures to protect your personal data from unauthorised access, loss, or misuse.
    </p>

    <h2>6. Your Rights</h2>
    <p>You have the right to:</p>
    <ul>
      <li>Access the personal data we hold about you</li>
      <li>Request correction or deletion of your data</li>
      <li>Withdraw consent for marketing communications</li>
    </ul>

    <h2>7. Contact Us</h2>
    <p>
      If you have any questions about this Privacy Policy, please contact us at:
    </p>
    <p>
      Email: homedomequeries@gmail.com
    </p>

    <h2>8. Changes to This Policy</h2>
    <p>
      We may update this policy from time to time. Any changes will be posted on this page.
    </p>

  </div>

@endsection