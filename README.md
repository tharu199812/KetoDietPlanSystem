# Developed by Tharushi Dissanayake - Kingston University ID: K2462662, Esoft metro campus ID: E185979

# Keto Diet Plan System

The **Keto Diet Plan System** is a web-based application designed to help **busy overweight individuals** create and follow personalized Keto diet plans. This system provides users with a structured approach to weight management through customized scheduling, nutritional tracking, and daily motivation.

---

## 🔍 Key Features

### 👤 User Features

#### Homepage
- Register as a new user.
- Log in as an existing user.
- Contact the admin for help via the **Contact Us** form.

#### Registration
- Secure form with email and password validation.
- After registering, users complete a **Q&A session** to help improve future diet plans.
- Redirects to login after Q&A submission.

#### Login
- Secure login for both new and returning users.
- **"Forgot Password"** option for recovery.

#### Dashboard
Main hub for managing the diet plan. Includes:
- **Schedule Your Diet Plan Form**
- **Diet Calendar**
- **Progress Bar**
- **Diet Plan Table**
- **Clear Diet Plan Button**

##### Schedule Your Diet Plan Form
Users fill in:
- Start Date (today or future)
- Duration of the plan
- Activity level
- Current & Target weight (with validations)
- Gender & Height (auto-filled from registration)
- Age group

🔁 After submitting, the system:
- Calculates required daily nutrition (calories, fats, carbs, protein).
- Matches values to predefined diet plans created by the admin (nutrition expert).
- Generates a diet schedule displayed in a **calendar format**.

📌 Note: If a diet plan already exists, users must clear it before creating a new one.

##### Diet Calendar
- Highlights today’s diet plan.
- Automatically removes past dates for user focus.

##### Progress Bar
- Displays how much of the schedule is completed (% based).

##### Diet Plan Table
- Shows a full record of past diet plans.

##### Clear Diet Plan Button
- Allows users to delete the current plan and start fresh.

#### Nutrition Search Bar
- Built with a **Nutrition API**.
- Search for food items and view nutritional values in table format.

#### Settings Page
- Users can update personal information and change passwords.

---

### 🛠️ Admin (Nutrition Specialist & System Owner)

#### Admin Homepage
- Create new diet plans using **Apply Diet Plan** form.
- View and delete user messages from the **Contact Us** page.
- Use the **"Send Diet Plans & Motivational Emails"** button to encourage users.

📅 Emails are sent daily automatically using a scheduled task. If the system fails, admin can send them manually.

#### Manage Diet Plans
- View all diet plans.
- Delete or update incorrect diet plans.

#### Q&A Results
- View user answers to Q&A in **pie chart format**.
- Use results to improve future diet plans based on user feedback.

---

## 🧠 How It Works

1. **Admin creates diet plans** based on different nutrition levels (calories, carbs, fats, protein).
2. **User fills the diet form** on the dashboard.
3. **System calculates nutritional needs** using a backend algorithm.
4. The system **matches a suitable plan** and builds a **personalized calendar**.
5. Users follow the plan and track their progress.
6. **Automated emails** are sent with diet info and motivation daily.

---

## 💡 Tech Stack

- **Frontend**: HTML, CSS, JavaScript  
- **Backend**: PHP  
- **Database**: MySQL (via XAMPP)  
- **Email & Task Scheduling**: PHP mail function + Cron job/task scheduler  
- **Nutrition Data**: External Nutrition API  
