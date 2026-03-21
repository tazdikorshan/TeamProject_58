@extends('layouts.app')

@section('title', 'Feedback')

@section('content')

<style>
  .star-rating {
    font-size: 2.5rem;
    color: #d3d3d3;
    cursor: pointer;
    margin-bottom: 10px;
  }


  .star-rating .star.active {
    color: #ffc107;
  }


  textarea {
    width: 100%;
    max-width: 500px;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-family: inherit;
    font-size: 1rem;
    resize: vertical;
  }


  button {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1rem;
  }

  button:hover {
    background-color: #0056b3;
  }

  .success-message {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 20px;
    font-weight: bold;
  }



  .login-prompt p {
    font-size: 1.1rem;
    color: #333;
    margin-top: 0;
    margin-bottom: 20px;
    font-weight: bold;
  }


  .login-prompt .button {
    display: inline-block;
    background-color: #F57C00;
    color: white;
    padding: 10px 24px;
    text-decoration: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: bold;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: background-color 0.2s, transform 0.1s;
  }


  .login-prompt .button:hover {
    background-color: #e65100;
    transform: translateY(-2px);
  }

  .login-prompt .button:active {
    transform: translateY(0);
  }
</style>
@guest
<div class="login-prompt">
  <p>You must be logged in to leave a review.</p>
  <a href="{{ route('login') }}" class="button">Log In Here</a>
</div>
@endguest

@auth
@if(session('success'))
<div class="success-message">
  {{ session('success') }}
</div>
@endif
<form id="review-form" action="/submit-review" method="POST">
  @csrf

  <div class="star-rating" id="stars-container">
    <span class="star" data-value="1">&#9733;</span>
    <span class="star" data-value="2">&#9733;</span>
    <span class="star" data-value="3">&#9733;</span>
    <span class="star" data-value="4">&#9733;</span>
    <span class="star" data-value="5">&#9733;</span>
  </div>

  <input type="hidden" id="rating-value" name="rating" value="0" required>

  <textarea id="review-text" name="review" rows="5" placeholder="Write your review here..." required></textarea>

  <br>
  <button type="submit">Submit Review</button>
</form>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-value');
    const reviewForm = document.getElementById('review-form');

    stars.forEach(star => {

      star.addEventListener('mouseover', function() {
        const value = this.getAttribute('data-value');
        fillStars(value);
      });


      star.addEventListener('mouseout', function() {
        fillStars(ratingInput.value);
      });


      star.addEventListener('click', function() {
        const value = this.getAttribute('data-value');
        ratingInput.value = value;
        fillStars(value);
      });
    });


    function fillStars(rating) {
      stars.forEach(star => {
        const starValue = star.getAttribute('data-value');
        if (starValue <= rating) {
          star.classList.add('active');
        } else {
          star.classList.remove('active');
        }
      });
    }


    if (reviewForm) {
      reviewForm.addEventListener('submit', function(e) {
        if (ratingInput.value === "0") {
          e.preventDefault();
          alert("Please select a star rating!");
        }
      });
    }
  });
</script>
@endauth
@endsection