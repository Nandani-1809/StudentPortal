<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Event Registration</title>

    <link rel="stylesheet" href="style2.css">
</head>

<body>

    <div class="registration-container">

        <h1>Event Registration</h1>
        <p>Fill in the details below to register for the event.</p>

        <form id="registrationForm"
              action="process.php"
              method="POST"
              novalidate>

            <!-- Name -->
            <div class="form-group">
                <label for="name">Full Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your full name"
                    required
                >
            </div>


            <!-- Enrollment Number -->
            <div class="form-group">
                <label for="enrollment">Enrollment Number</label>

                <input
                    type="text"
                    id="enrollment"
                    name="enrollment"
                    placeholder="Enter enrollment number"
                    required
                >
            </div>


            <!-- Email -->
            <div class="form-group">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >
            </div>


            <!-- Mobile -->
            <div class="form-group">
                <label for="mobile">Mobile Number</label>

                <input
                    type="tel"
                    id="mobile"
                    name="mobile"
                    placeholder="Enter 10-digit mobile number"
                    required
                >
            </div>


            <!-- Date of Birth -->
            <div class="form-group">
                <label for="dob">Date of Birth</label>

                <input
                    type="date"
                    id="dob"
                    name="dob"
                    required
                >
            </div>


            <!-- Gender -->
            <div class="form-group">
                <label>Gender</label>

                <div>
                    <label>
                        <input
                            type="radio"
                            name="gender"
                            value="Male"
                            required
                        >
                        Male
                    </label>

                    <label>
                        <input
                            type="radio"
                            name="gender"
                            value="Female"
                        >
                        Female
                    </label>

                    <label>
                        <input
                            type="radio"
                            name="gender"
                            value="Other"
                        >
                        Other
                    </label>
                </div>
            </div>


            <!-- Department -->
            <div class="form-group">
                <label for="department">Department</label>

                <select
                    id="department"
                    name="department"
                    required
                >
                    <option value="">Select Department</option>
                    <option value="CSE">Computer Science and Engineering</option>
                    <option value="IT">Information Technology</option>
                    <option value="CE">Computer Engineering</option>
                    <option value="EC">Electronics and Communication</option>
                    <option value="ME">Mechanical Engineering</option>
                </select>
            </div>


            <!-- Year -->
            <div class="form-group">
                <label for="year">Year</label>

                <select
                    id="year"
                    name="year"
                    required
                >
                    <option value="">Select Year</option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                </select>
            </div>


            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Create a password"
                    required
                    minlength="6"
                >
            </div>


            <!-- Confirm Password -->
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>

                <input
                    type="password"
                    id="confirmPassword"
                    name="confirmPassword"
                    placeholder="Confirm your password"
                    required
                    minlength="6"
                >
            </div>


            <!-- Terms -->
            <div class="form-group">
                <label>
                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                        value="accepted"
                        required
                    >

                    I agree to the terms and conditions.
                </label>
            </div>


            <!-- Submit -->
            <button type="submit">
                Register
            </button>

        </form>

    </div>


    <script src="script.js"></script>

</body>
</html>