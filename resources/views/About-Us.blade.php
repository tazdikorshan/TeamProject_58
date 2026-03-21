@extends('layouts.app')

@section('title', 'About Us')

@section('content')

<style>
:root {
  --hd-orange: #F57C00;
  --hd-orange-brown: #E67E22;
  --hd-dark-red: #B03A2E;
  --hd-black: #000000;
}

.About-us {
  position: relative;
  text-align: left;
  margin-top: 16px;
}

.About-us img {
  display: block;
  margin: auto;
  width: 96%;
  height: 500px;
  border-radius: 12px;
  object-fit: cover;
}

.About-us h1 {
  position: absolute;
  top: 60px;
  left: 100px;
  color: white;
  font-size: 60px;
  font-weight: 900;
  text-shadow: 4px 4px 12px rgba(0,0,0,0.6);
  letter-spacing: 2px;
}

.Welcome {
  text-align: center;
  width: 80%;
  margin: 40px auto 50px auto;
}

.Welcome p {
  font-size: 24px;
  font-weight: 500;
  color: black;
  line-height: 1.7;
}

.us-info {
  width: 85%;
  margin: auto;
  line-height: 1.8;
}

h2 {
  font-size: 38px;
  font-weight: 900;
  margin-bottom: 15px;
  color: black;
  text-align: center;
}

#p1 {
  width: 100%;
  background: var(--hd-orange);
  padding: 35px;
  border-radius: 15px;
  box-shadow: 0px 4px 18px rgba(0,0,0,0.15);
  text-align: center;
  font-size: 20px;
  color: white;
}

.card-section {
  width: 85%;
  margin: 60px auto;
}

.cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 30px;
  margin-top: 30px;
}

.card {
  background: white;
  padding: 25px;
  border-radius: 15px;
  border: 3px solid brown;
  box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

.card h3 {
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 12px;
  color: #B03A2E;
}

.card p {
  font-size: 17px;
  line-height: 1.6;
  color: black;
}

.end {
  width: 90%;
  margin: 60px auto 80px auto;
  padding: 44px;
  text-align: center;
  background: var(--hd-orange);
  color: white;
  border-radius: 16px;
}

.end h2 {
  font-size: 34px;
  margin-bottom: 8px;
  font-weight: 900;
  color: white;
}

.end p {
  font-size: 18px;
  margin-bottom: 18px;
}

.end-button {
  background: white;
  color: brown;
  padding: 12px 26px;
  font-size: 16px;
  border-radius: 999px;
  border: none;
  cursor: pointer;
}
</style>
<div class="About-us">
  <img src="{{ asset('images/furnture & appliances in a room.png') }}" alt="About us banner">
  <h1><strong><u>About Us</u></strong></h1>
</div>

<div class="Welcome">
  <p><i>
    Welcome to HomeDome where comfort, style, and smart living come together.
    We’re your one-stop destination for modern furniture and high quality home appliances.
  </i></p>
</div>

<div class="us-info">
  <h2>Who We Are</h2>
  <p id="p1">
    At HomeDome, we are a team dedicated to helping people create comfortable and beautiful living spaces.
    We offer a wide range of modern furniture, innovative appliances, and practical home solutions that bring
    style, reliability, and convenience into everyday life.
  </p>
</div>

<section class="card-section">
  <div class="cards">
    <div class="card">
      <h3>Our Mission</h3>
      <p>
        To provide high quality furniture and appliances that enhance everyday living through thoughtful design
        and reliable craftsmanship.
      </p>
    </div>

    <div class="card">
      <h3>Our Vision</h3>
      <p>
        To become the most trusted home living brand, inspiring comfort and creativity in every household.
      </p>
    </div>

    <div class="card">
      <h3>Our Values</h3>
      <p>
        Quality, integrity, innovation, and customer-first service guide everything we do.
      </p>
    </div>
  </div>
</section>

<section class="end">
  <h2>Let’s Build Your Dream Home Together!</h2>
  <p>
    Explore our collections and let us help you bring your home to life.
  </p>
  <a href="/"><button class="end-button">Shop Now</button></a>
</section>
@endsection