<?php include('../backend/db.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mess Booking</title>
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="" rel="stylesheet" />
    <style>
      .section {
        position: relative;
        height: 100vh;
      }

      .section .section-center {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
      }

      #booking {
        font-family: "Montserrat", sans-serif;
        background-image: url("https://wallpapers.com/downloads/high/food-4k-4080-x-2295-9g4bc6lii3nfmbbm.webp?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80");
        background-size: cover;
        background-position: center;
      }

      #booking::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        background: rgba(47, 157, 177, 0.34);
      }

      .booking-form {
        background-color: #fff;
        padding: 50px 20px;
        -webkit-box-shadow: 0px 5px 20px -5px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 5px 20px -5px rgba(0, 0, 0, 0.3);
        border-radius: 4px;
      }

      .booking-form .form-group {
        position: relative;
        margin-bottom: 30px;
      }

      .booking-form .form-control {
        background-color:rgb(217, 219, 221);
        border-radius: 4px;
        border: none;
        height: 40px;
        -webkit-box-shadow: none;
        box-shadow: none;
        color: #3e485c;
        font-size: 14px;
      }

      .booking-form .form-control::-webkit-input-placeholder {
        color: rgba(62, 72, 92, 0.3);
      }

      .booking-form .form-control:-ms-input-placeholder {
        color: rgba(62, 72, 92, 0.3);
      }

      .booking-form .form-control::placeholder {
        color: rgba(62, 72, 92, 0.3);
      }

      .booking-form input[type="date"].form-control:invalid {
        color: rgba(62, 72, 92, 0.3);
      }

      .booking-form select.form-control {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
      }

      .booking-form select.form-control + .select-arrow {
        position: absolute;
        right: 0px;
        bottom: 4px;
        width: 32px;
        line-height: 32px;
        height: 32px;
        text-align: center;
        pointer-events: none;
        color: rgba(62, 72, 92, 0.3);
        font-size: 14px;
      }

      .booking-form select.form-control + .select-arrow:after {
        content: "\279C";
        display: block;
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg);
      }

      .booking-form .form-label {
        display: inline-block;
        color: #3e485c;
        font-weight: 700;
        margin-bottom: 6px;
        margin-left: 7px;
      }

      .booking-form .submit-btn {
        display: inline-block;
        color: #fff;
        background-color: #1e62d8;
        font-weight: 700;
        padding: 14px 30px;
        border-radius: 4px;
        border: none;
        -webkit-transition: 0.2s all;
        transition: 0.2s all;
      }

      .booking-form .submit-btn:hover,
      .booking-form .submit-btn:focus {
        opacity: 0.9;
      }

      .booking-cta {
        margin-top: 80px;
        margin-bottom: 30px;
      }

      .booking-cta h1 {
        font-size: 52px;
        text-transform: uppercase;
        color: #000000;
        font-weight: 700;
      }

      .booking-cta h4 {
        font-size: auto;
        color: rgb(61, 57, 57);
      }

       @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

      .booking-cta h1,
      .booking-cta h4,
      .booking-form,
      .snippet-body,
      .section {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.9s ease forwards;
      }

      @media (max-width: 767px) {
        .booking-cta h1 {
          font-size: 36px;
        }
      }
    </style>
    <script type="text/javascript" src=""></script>
    <script
      type="text/javascript"
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    ></script>
    <script
      type="text/javascript"
      src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
    ></script>
  </head>
  <body oncontextmenu="return false" class="snippet-body">
    <div id="booking" class="section">
      <div class="section-center">
        <div class="container">
          <div class="row">
            <div class="col-md-7 col-md-push-5">
              <div class="booking-cta">
                <h1>book your mess</h1>
                <h4>
                  Choose your meals, set the duration, and you're done!
               </h4>
              </div>
            </div>
            <div class="col-md-4 col-md-pull-7">
              <div class="booking-form">
                <form
                  action="submit-mess-booking.php"
                  method="POST"
                  oninput="calculateAmount()"
                >
                  <div class="form-group">
                    <span class="form-label">Email</span>
                    <input
                      class="form-control"
                      type="text"
                      id = "student_email"
                      name="student_email"
                      placeholder="Enter your email"
                      required
                    />
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <span class="form-label">Meal Plan</span><br />
                        <input
  type="checkbox"
  name="meal_plan[]"
  value="Breakfast"
  id="breakfast"
/> Breakfast (₹50)<br />
<input
  type="checkbox"
  name="meal_plan[]"
  value="Lunch"
  id="lunch"
/> Lunch (₹100)<br />
<input
  type="checkbox"
  name="meal_plan[]"
  value="Dinner"
  id="dinner"
/> Dinner (₹80)<br />

                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <span class="form-label">Duration (in Months)</span>
                        <input class="form-control" type="number" id="duration" name="duration" min="1" value="1" required />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <span class="form-label">Total Amount (₹)</span>
                        <input class="form-control" type="number" id="total_amount" name="total_amount" readonly />
                      </div>
                    </div>
                  </div>
                  <div class="form-btn">
                    <button class="submit-btn">Book Mess</button>
                  </div>
                  <div>
                  <br>
                  <a href="../backend/room-list.php" class="submit-btn">Back to the rooms</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript"></script>
    <script>
  function calculateAmount() {
    const prices = {
      breakfast: 50,
      lunch: 100,
      dinner: 80
    };

    const duration = parseInt(document.getElementById('duration').value) || 0;
    const totalDays = duration * 30;

    let dailyTotal = 0;
    if (document.getElementById('breakfast').checked) dailyTotal += prices.breakfast;
    if (document.getElementById('lunch').checked) dailyTotal += prices.lunch;
    if (document.getElementById('dinner').checked) dailyTotal += prices.dinner;

    const total = dailyTotal * totalDays;
    document.getElementById('total_amount').value = total;
  }

  // Initial calculation
  window.onload = calculateAmount;
</script>
  </body>
</html>
